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

/* Gaya untuk container gambar */
.modal-view-image-container {
    position: relative;
    overflow: hidden;
    width: 100%; /* Lebar awal gambar dalam modal */
    height: 400px; /* Tinggi awal gambar dalam modal */
    margin-bottom: 20px;
}

/* Gaya untuk gambar */
.modal-view-image {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Agar gambar terisi container dengan proporsi yang benar */
    transition: transform 0.3s ease;
}

/* Gaya untuk overlay pada gambar */
.modal-view-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5); /* Warna overlay */
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0; /* Mulai dengan tidak terlihat */
    transition: opacity 0.3s ease;
}

/* Gaya untuk teks zoom */
.modal-view-image-zoom {
    color: white;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
}

/* Hover effect untuk overlay dan gambar */
.modal-view-image-container:hover .modal-view-image {
    transform: scale(1.1); /* Memperbesar gambar saat di hover */
}

.modal-view-image-container:hover .modal-view-image-overlay {
    opacity: 1; /* Menampilkan overlay saat di hover */
}

/* Animasi untuk tombol saat hover */
.btn-lihat,
.btn-ubah,
.btn-hapus {
    transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
}

/* Tombol Lihat */
.btn-lihat:hover {
    background-color: #007bff; /* Warna biru */
    border-color: #007bff; /* Warna border biru */
    color: #fff; /* Warna teks putih */
}

/* Tombol Ubah */
.btn-ubah:hover {
    background-color: #007bff; /* Warna biru */
    border-color: #007bff; /* Warna border biru */
    color: #fff; /* Warna teks putih */
}

/* Tombol Hapus */
.btn-hapus:hover {
    background-color: #007bff; /* Warna biru */
    border-color: #007bff; /* Warna border biru */
    color: #fff; /* Warna teks putih */
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
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar</label>
                        <input class="form-control" id="image" type="file" name="image" accept=".png, .jpg, .jpeg">
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input id="title" name="title" class="form-control" type="text">
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Isi</label>
                        <textarea id="content" name="content" class="form-control" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<!-- Modal View-->
@if(isset($theNews))
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body position-relative">
                <div class="modal-view-image-container rounded border">
                    <img class="img-fluid mb-3 modal-view-image"
                         src="{{ $theNews->getImageUrl() ? asset('storage/images/news/' . $theNews->getImageUrl()) : asset('assets/img_placeholder.jpeg') }}"
                         alt="{{ $theNews->getImageUrl() }}">
                    <div class="modal-view-image-overlay">
                        <div class="modal-view-image-zoom">Klik untuk Zoom</div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="in-v-title" class="form-label">Judul</label>
                    <input id="in-v-title" class="form-control" type="text" value="{{ $theNews->getTitle() }}" disabled>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="in-v-creator" class="form-label">Pembuat</label>
                        <input id="in-v-creator" class="form-control" type="text" value="{{ $theNews->getUser()->getName() }}" disabled>
                    </div>
                    <div class="col">
                        <label for="in-v-date" class="form-label">Tanggal</label>
                        <input id="in-v-date" class="form-control" type="text" value="{{ $theNews->getCreatedAt() }}" disabled>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="in-v-content" class="form-label">Isi</label>
                    <textarea id="in-v-content" class="form-control" rows="10" disabled>{{ $theNews->getContent() }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

@endif

<!-- Modal EDIT-->
@if(isset($theNews))
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah {{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('news.update', $theNews->getId()) }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body position-relative">
                <div class="modal-view-image-container rounded border">
                        <img class="img-fluid modal-view-image"
                            src="{{ $theNews->getImageUrl() ? url('/storage/images/news/' . $theNews->getImageUrl()) : URL::asset('/assets/img_placeholder.jpeg') }}"
                            alt="{{ $theNews->getImageUrl() }}">
                        <label for="image" class="form-label mt-2">Gambar</label>
                        <input class="form-control" id="image" type="file" name="image" accept=".png, .jpg, .jpeg">
                    </div>

                    <div class="mb-3">
                        <label for="in-e-title" class="form-label">Judul</label>
                        <input id="in-e-title" name="title" value="{{ $theNews->getTitle() }}" class="form-control" type="text">
                    </div>

                    <div class="mb-3">
                        <label for="in-e-content" class="form-label">Isi</label>
                        <textarea id="in-e-content" name="content" class="form-control" rows="5">{{ $theNews->getContent() }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
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
                    <input class="my-btn-secondary small-btn btn-lihat" type="submit" value="Lihat">
                    <input type="text" name="isEdit" value="0" hidden/>
                </form>

                <form method="POST" action="{{ route('news.show', $d->getId())  }}">
                    @csrf
                    <input class="my-btn-secondary small-btn btn-ubah" type="submit" value="Ubah">
                    <input type="text" name="isEdit" value="1" hidden/>
                </form>

                <form method="POST" action="{{ route('news.delete', $d->getId())  }}">
                    @csrf
                    <input class="my-btn-secondary small-btn btn-hapus" type="submit" value="Hapus">
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


<<script type="text/javascript">
   
   window.addEventListener('load', function () {
       messageDialog();
       newsDialog();
       openOriginalImage();
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

   function openOriginalImage() {
       $(document).on('click', '.modal-view-image-zoom', function() {
           let imgUrl = $(this).closest('.modal-body').find('.modal-view-image').attr('src');
           if (imgUrl && imgUrl !== 'undefined') {
               let modal = $('<div class="modal fade" id="imageZoomModal" tabindex="-1" aria-hidden="true">\
                                   <div class="modal-dialog modal-lg">\
                                       <div class="modal-content">\
                                           <div class="modal-body">\
                                               <img class="img-fluid" src="' + imgUrl + '">\
                                           </div>\
                                       </div>\
                                   </div>\
                               </div>');
               modal.modal('show');

               // Hapus modal imageZoomModal setelah ditutup
               modal.on('hidden.bs.modal', function () {
                   $(this).remove();
               });
           } else {
               console.error('Invalid image source');
           }
       });
   }

</script>

