<style>
    .berita-desc {
        overflow: hidden;
        width: 100%;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .berita-header {
        align-items: center;
        background: var(--red-primary);
        border-radius: 16px;
        color: white;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 10px 20px;
    }

    .item-berita {
        display: flex;
        flex-direction: row;
        border-radius: 8px;
        box-shadow: 0 0 4px grey;
        padding: 10px;
    }

    .item-berita-action {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .item-berita-image {
        width: 200px;
        height: 100px;
        background-color: var(--red-primary);
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 0 2px grey;
    }

    .item-berita-content {
        display: flex;
        flex: 1;
        flex-direction: column;
        justify-content: start;
    }

    .list-content {
        height: calc(100vh - (<?= $data->lastPage() == 1 ? '200px': '235px'?>));
        overflow: scroll;
        padding: 10px;
    }

    .small-btn {
        height: 30px;
        padding: 5px 20px;
        font-size: 14px;
    }

    .news-info-image {
        background-color: var(--red-primary);
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 0 2px black;
    }

    .news-info-1 {
        display: flex;
        flex-direction: row;
        gap: 10px;
    }

</style>

@php
    $theNews = Session::get('newsValue') ?? null;
@endphp

    <!-- Modal ADD-->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah {{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('news.create') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label for="in-a-title" class="label">Gambar</label>
                    <input class="my-input" type="file" name="image" accept=".png, .jpg, .jpeg">

                    <label for="in-a-title" class="label mt-2">Judul</label>
                    <input id="in-a-title"
                           name="title"
                           class="my-input"
                           type="text">

                    <label for="in-a-content" class="label mt-2">Isi</label>
                    <textarea id="in-a-content" name="content" class="my-text-area" rows="5" cols="50"></textarea>
                </div>
                <div class="modal-footer">
                    <div>
                        <input type="submit"
                               value="Save"
                               class="btn my-btn-primary"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal View-->
@if(isset($theNews))
    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img class="news-info-image"
                         src="{{ $theNews->getImageUrl() ? url('/storage/images/news/' . $theNews->getImageUrl() ): URL::asset('/assets/img_placeholder.jpeg') }}"
                         alt="{{ $theNews->getImageUrl()  }}">

                    <label for="in-v-title" class="label mt-2">Judul</label>
                    <input id="in-v-title"
                           class="my-input"
                           type="text"
                           value="{{ $theNews->getTitle()  }}" disabled>

                    <div class="news-info-1 mt-2">
                        <div>
                            <label for="in-v-creator" class="label">Pembuat</label>
                            <input id="in-v-creator"
                                   class="my-input"
                                   type="text"
                                   value="{{ $theNews->getUser()->getName()  }}" disabled>

                        </div>

                        <div>
                            <label for="in-v-date" class="label">Tanggal</label>
                            <input id="in-v-date"
                                   class="my-input"
                                   type="text"
                                   value="{{ $theNews->getCreatedAt()  }}" disabled>
                        </div>
                    </div>

                    <label for="in-v-content" class="label mt-2">Isi</label>
                    <textarea id="in-v-content" class="my-text-area" rows="10" cols="50"
                              disabled>{{ $theNews->getContent()  }}</textarea>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Modal EDIT-->
@if(isset($theNews))
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('news.update', $theNews->getId())  }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <img class="news-info-image"
                             src="{{ $theNews->getImageUrl() ? url('/storage/images/news/' . $theNews->getImageUrl() ): URL::asset('/assets/img_placeholder.jpeg') }}"
                             alt="{{ $theNews->getImageUrl()  }}">

                        <label for="in-e-title" class="label mt-2">Gambar</label>
                        <input class="my-input"
                               type="file"
                               name="image"
                               accept=".png, .jpg, .jpeg">

                        <label for="in-e-title" class="label mt-2">Judul</label>
                        <input id="in-e-title"
                               name="title"
                               value="{{ $theNews->getTitle()  }}"
                               class="my-input"
                               type="text">

                        <label for="in-e-content" class="label mt-2">Isi</label>
                        <textarea id="in-e-content"
                                  name="content"
                                  class="my-text-area"
                                  rows="5"
                                  cols="50">{{ $theNews->getContent()  }}</textarea>
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

<div class="berita-header">
    <h3>{{ $title  }}</h3>
    <div>
        <input class="my-btn-secondary"
               type="button"
               value="Tambah"
               data-bs-toggle="modal"
               data-bs-target="#addModal">
    </div>
</div>

<div class="mt-2">
    <ul class="list-content">
        @forelse($data as $d)
            <li class="item-berita mb-2">
                <img class="item-berita-image"
                     src="{{ $d->getImageUrl() ? url('/storage/images/news/' . $d->getImageUrl() ): URL::asset('/assets/img_placeholder.jpeg') }}"
                     alt="{{ $d->getImageUrl()  }}">

                <div class="item-berita-content ms-2">
                    <h5>{{ $d->getTitle()  }}</h5>
                    <p class="berita-desc">{{ $d->getContent()  }}</p>
                </div>

                <div class="item-berita-action ms-2">
                    <form method="POST" action="{{ route('news.show', $d->getId())  }}">
                        @csrf
                        <input class="my-btn-secondary small-btn"
                               type="submit"
                               value="Lihat">
                        <input type="text" name="isEdit" value="0" hidden/>
                    </form>

                    <form method="POST" action="{{ route('news.show', $d->getId())  }}">
                        @csrf
                        <input class="my-btn-secondary small-btn"
                               type="submit"
                               value="Ubah">
                        <input type="text" name="isEdit" value="1" hidden/>
                    </form>

                    <form method="POST" action="{{ route('news.delete', $d->getId())  }}">
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
        messageDialog();
        newsDialog();
    })

    function newsDialog() {
        let isEdit = {!! json_encode($isEdit) !!};
        let viewNews = {!! json_encode($theNews) !!};

        console.log('news-dialog-1');

        if (!viewNews) return;

        console.log('news-dialog-2');

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
