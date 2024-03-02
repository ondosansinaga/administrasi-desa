<style>
    .list-content {
        height: calc(100vh - (<?= $data->lastPage() == 1 ? '150px': '200px'?>));
        overflow: scroll;
        padding: 10px;
    }

    .item-req-letter {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: row;
        border-radius: 8px;
        box-shadow: 0 0 4px grey;
        padding: 10px;
    }

    .doc-req-letter {
        width: 160px;
        height: 160px;
        background-color: var(--red-primary);
        object-fit: contain;
        border-radius: 8px;
    }

    .item-req-letter-content {
        display: flex;
        flex: 1;
        flex-direction: column;
        justify-content: start;
    }

    .item-req-letter-action {
        display: flex;
        flex-direction: column;
        gap: 20px;
        justify-content: space-between;
    }

    .item-req-letter-label {
        font-size: 12px;
    }

    .item-req-letter-value {
        font-weight: bold;
    }

    .small-btn {
        height: 30px;
        padding: 5px 20px;
        font-size: 14px;
    }

</style>

@php
    $reqLetter = Session::get('reqLetterValue') ?? null;
    if(isset($reqLetter))
    {
        $date = date_create($reqLetter->getDateRequest());
        $formatDate = date_format($date,"d-m-Y");
    }

@endphp

    <!-- Modal View-->
@if(isset($reqLetter))
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pengajuan Surat - {{ $reqLetter->getUser()->getName() }}
                        - {{ $formatDate }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="in-a-role" class="item-req-letter-label">NIK</label>
                        <p class="item-req-letter-value" id="in-a-role">{{ $reqLetter->getUser()->getNik() }}</p>
                    </div>

                    <div>
                        <label for="in-a-role" class="item-req-letter-label">Nama</label>
                        <p class="item-req-letter-value" id="in-a-role">{{ $reqLetter->getUser()->getName() }}</p>
                    </div>

                    <div>
                        <label for="in-a-role" class="item-req-letter-label">Jenis Surat</label>
                        <p class="item-req-letter-value" id="in-a-role">{{ $reqLetter->getLetter()->getTitle() }}</p>
                    </div>

                    <div>
                        <label for="in-a-role" class="item-req-letter-label">Tanggal Pengajuan</label>
                        <p class="item-req-letter-value" id="in-a-role">{{ $formatDate }}</p>
                        
                    </div>

                    <label for="in-status" class="item-req-letter-label mt-2">Status</label>
                    <select id="in-status" class="form-select" name="status" disabled>
                        <option value="0" {{ $reqLetter->getStatus() == '0'? 'selected' : ''  }}>Pending</option>
                        <option value="1" {{ $reqLetter->getStatus() == '1'?  'selected' : ''  }}>Accepted</option>
                        <option value="2" {{$reqLetter->getStatus() == '2'? 'selected' : ''  }}>Rejected</option>
                    </select>
                    
                    
                  

                    
                    <label class="item-req-letter-label mt-2">Permohonan Pengajuan Surat</label>
                        <div>
                        <a target="_blank" href="{{ route('cetak.surat', $reqLetter->getId()) }}" class="item-req-letter-label">Lihat Surat</a>
                        </div>
                    

                    @if($reqLetter->getDocUrl())
                        <label class="item-req-letter-label mt-2">Pengajuan Surat di Terima</label>
                        <div>
                            <a target=”_blank” href="{{  url('/storage/documents/' . $reqLetter->getDocUrl()) }}">{{ $reqLetter->getDocUrl()  }}</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endif

<!-- Modal Edit-->
@if(isset($reqLetter))
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pengajuan Surat - {{ $reqLetter->getUser()->getName() }}
                        - {{ $formatDate  }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST"
                      action="{{ route('req-letter.update', $reqLetter->getId()) }}"
                      enctype="multipart/form-data">
                    @csrf

                <div class="modal-body">
                    <div>
                        <label for="in-a-role" class="item-req-letter-label">NIK</label>
                        <p class="item-req-letter-value" id="in-a-role">{{ $reqLetter->getUser()->getNik() }}</p>
                    </div>

                    <div>
                        <label for="in-a-role" class="item-req-letter-label">Nama</label>
                        <p class="item-req-letter-value" id="in-a-role">{{ $reqLetter->getUser()->getName() }}</p>
                    </div>

                    <div>
                        <label for="in-a-role" class="item-req-letter-label">Jenis Surat</label>
                        <p class="item-req-letter-value" id="in-a-role">{{ $reqLetter->getLetter()->getTitle() }}</p>
                    </div>

                    <div>
                        <label for="in-a-role" class="item-req-letter-label">Tanggal Pengajuan</label>
                        <p class="item-req-letter-value" id="in-a-role">{{ $formatDate }}</p>
                    </div>

                    <label for="in-status" class="item-req-letter-label mt-2">Status</label>
                    <select id="in-status" class="form-select" name="status">
                        <option value="0" {{ $reqLetter->getStatus() == '0'? 'selected' : ''  }}>Pending</option>
                        <option value="1" {{ $reqLetter->getStatus() == '1'?  'selected' : ''  }}>Accepted</option>
                        <option value="2" {{ $reqLetter->getStatus() == '2'? 'selected' : ''  }}>Rejected</option>
                    </select>

                    <label for="in-status" class="item-req-letter-label mt-2">File</label>
                    <input
                        id="in-status"
                        name="doc"
                        class="my-input"
                        type="file"
                        accept=".pdf">
                </div>

                <div class="modal-footer">
                    <div>
                        <input
                            type="submit"
                            value="Update"
                            class="btn my-btn-primary"/>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
@endif

<div>
    <h3>{{ $title  }}</h3>
</div>

<div class="mt-2">
    <ul class="list-content">
        @forelse($data as $d)
            @php
                $ddate = date_create($d->getDateRequest());
                $formatDDate = date_format($ddate,"d-m-Y");
            @endphp
            <li class="item-req-letter mb-2">
                <img class="doc-req-letter"
                     src="{{ URL::asset('/assets/ic_doc.png') }}"
                     alt="Dokumen">

                <div class="item-req-letter-content ms-3">
                    <div>
                        <label for="in-a-role" class="item-req-letter-label">NIK</label>
                        <p class="item-req-letter-value" id="in-a-role">{{ $d->getUser()->getNik() }}</p>
                    </div>

                    <div>
                        <label for="in-a-role" class="item-req-letter-label">Nama</label>
                        <p class="item-req-letter-value" id="in-a-role">{{ $d->getUser()->getName() }}</p>
                    </div>

                    <div>
                        <label for="in-a-role" class="item-req-letter-label">Jenis Surat</label>
                        <p class="item-req-letter-value" id="in-a-role">{{ $d->getLetter()->getTitle() }}</p>
                    </div>

                    <div>
                        <label for="in-a-role" class="item-req-letter-label">Tanggal Pengajuan</label>
                        <p class="item-req-letter-value" id="in-a-role">{{ $formatDDate }}</p>
                    </div>
                </div>

                <div class="item-req-letter-action ms-2">
                    <form method="POST" action="{{ route('req-letter.show', $d->getId())  }}">
                        @csrf
                        <input class="my-btn-secondary small-btn"
                               type="submit"
                               value="Lihat">
                        <input type="text" name="isEdit" value="{{false}}" hidden/>
                    </form>

                    <form method="POST" action="{{ route('req-letter.show', $d->getId())  }}">
                        @csrf
                        <input class="my-btn-secondary small-btn"
                               type="submit"
                               value="Ubah">
                        <input type="text" name="isEdit" value="{{true}}" hidden/>
                    </form>

                    <form method="POST" action="{{ route('req-letter.delete', $d->getId())  }}">
                        @csrf
                        <input class="my-btn-secondary small-btn"
                               type="submit"
                               value="Hapus">
                    </form>
                </div>
            </li>
        @empty
            <h6>{{$title}} kosong</h6>
        @endforelse
    </ul>

    <div>
        {{ $data->onEachSide(1)->links() }}
    </div>
</div>

@php
    $isEdit = Session::get('isEdit') ?? false;
@endphp

<script type="text/javascript">
    window.addEventListener('load', function () {
        reqLetterDialog();
        messageDialog();
    });

    function reqLetterDialog() {
        let isEdit = {!! json_encode($isEdit) !!};
        let viewReqLetter = {!! json_encode($reqLetter) !!};

        if (!viewReqLetter) return;

        if (isEdit) {
            console.log('edit');
            let modal = new bootstrap.Modal(document.getElementById('editModal'), {
                keyboard: false,
                backdrop: 'static'
            });
            modal.show();
        } else {
            console.log('view');
            let modal = new bootstrap.Modal(document.getElementById('viewModal'), {
                keyboard: false,
                backdrop: 'static'
            });
            modal.show();
        }
    }

    function messageDialog() {
        let message = {!! json_encode($message) !!};
        let successMessage = message?.success ?? null;
        let errorMessage = message?.error ?? null;

        if (successMessage) {
            showSuccessMessage(successMessage)
        }

        if (errorMessage) {
            showErrorMessage(errorMessage)
        }
    }
</script>

