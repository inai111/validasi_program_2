@extends('layouts.app')

@section('scriptsVite')
    @vite('resources/js/bundle/show-file.bundle.js')
@endsection

@section('body')
<style>
    body{
        background-color:var(--bs-gray-300)!important;
    }
    #viewerContainer {
      overflow: auto;
      position: absolute;
      width: 100%;
      height: 100%;
    }
</style>
    <div id="appPdf" class="pb-3">
        <div class="toolbar">
            <nav class="navbar bg-light" data-bs-theme="dark"
            style="position: fixed;top: 0;margin-top: 3rem;width: -moz-available;z-index: 1000;">
                <div class="container-fluid">
                    <input type="number" v-model="page" min="1" v-on:change="page=2;showPdfPage()"
                        :max="pageMax">
                    <div class="navbar-nav flex-row gap-3">
                        <a class="nav-link" href="#">
                            <button ref="stampButton" v-on:click="openModal()" class="btn btn-outline-primary btn-sm">
                                Stamp
                            </button>
                        </a>
                        <a class="nav-link" href="#">
                            <button v-on:click="editText" class="px-5 btn btn-primary btn-sm">
                                Save
                            </button>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div class="mx-auto pt-4 mt-5">
            <div id="viewerContainer">
                <div id="viewer" class="pdfViewer"></div>
            </div>
            {{-- <div id="containerPdf" class="pdfViewer singlePageView"> --}}
        </div>

        {{-- <div class="wrapper pt-4">
            <div class="mt-5" id="containerPd" style="display: none">

                <div class="mb-3">
                    <div class="position-relative pdf-page border border-2 mb-3 mx-auto bg-light"
                        style="width:595px;height:842px">
                        <div class="mb-3">
                            <canvas></canvas>
                        </div>
                        <div class="stamp-container">
                            <div id="stamp-1" class="draggable border" style="width:100px;height:100px;">
                                <img style="object-fit: fill;object-position: center;width: 100%;height: 100%;"
                                    src="https://o-cdf.sirclocdn.com/unsafe/o-cdn-cas.sirclocdn.com/parenting/images/Cara-Menggambar-Pemandangan-hello.width-800.format-webp.webp"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="modal" id="modalStamp" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Modal title</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" v-on:submit="uploadFile">
                        <div class="mb-3">
                            <input type="file" required class="form-control" name="image"
                            accept="image/png,image/jpeg,image/jpg">
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection
