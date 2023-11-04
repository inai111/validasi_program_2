import {
  createApp
} from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';


import { getDocument, GlobalWorkerOptions, pdfdo } from "pdfjs-dist";
import { PDFDocument, rgb } from 'pdf-lib';
import 'pdfjs-dist/web/pdf_viewer.css';

import interact from 'interactjs';
import axios from 'axios';
import { EventBus, PDFPageView, PDFViewer } from 'pdfjs-dist/web/pdf_viewer';

const appPdf = createApp({
  data() {
    return {
      stamp: {},
      fileUrl: location.pathname.replace('/edit', '?'+new Date().getTime()),
      container:document.querySelector(`#containerPdf`),
      page: 1,
      pageMax: 0,
      pdfRead: {},
      pdfViewOption: {},
      stampIsDragging: 0,
      position: {},
      pagesPdf: [],
      modal: {},
      imageUrl:"",
      imageBuff:{},
      disabledStamp:false
    }
  },
  mounted() {
    this.initPdfView();
    let modal = {
      modalElem: new bootstrap.Modal(document.getElementById('modalStamp')),
      show: function () { this.modalElem.show() },
      hide: function () { this.modalElem.hide() }
    }
    this.modal = modal;
  },
  methods: {
    changePage() {

    },
    async initPdfView() {
      GlobalWorkerOptions.workerSrc = '/build/assets/pdf.worker.js';

      // Document loaded, retrieving the page.
      const eventBus = new EventBus();
      const loadingTask = getDocument(this.fileUrl);
      const pdfDocument = await loadingTask.promise;
      const container = document.getElementById("viewerContainer");

      this.pageMax = pdfDocument._pdfInfo.numPages

      const pdfPageView = new PDFViewer({
        container,
        eventBus,
      });

      // // Associate the actual page with the view, and draw it.
      pdfPageView.setDocument(pdfDocument);
      pdfPageView.eventBus.on('pagechanging', function (e) {
        appPdf.page = e.pageNumber;
      });
    },
    async editText() {
      // Baca file PDF yang akan diedit
      const filePath = location.pathname.replace('/edit', '');
      const filePdf = await fetch(filePath).then(res => res.arrayBuffer())
      const pdfBuffer = filePdf;
      const pdfDoc = await PDFDocument.load(pdfBuffer);

      // cek semua dari page yang telah di tampilkan
      document.querySelectorAll(`#viewerContainer .page`).forEach(page=>{
        const stamps = page.querySelectorAll(`.stamp-container .draggable`);
        const canvaY = page.querySelector('canvas').style.height.replace('px','');
        if(stamps.length > 0){
          const pagePdf = pdfDoc.getPages()[page.dataset.pageNumber-1];
          stamps.forEach(async stamp=>{
            const width = stamp.style.width||"100px";
            const height = stamp.style.height||"100px";
            const transform = stamp.style.transform||"translate(0px, 0px)";
            const xy = transform.match(/-?[\d\.]+/g);
            const x = xy[0];
            const y = xy[1]??1;
            const imageJpeg = await pdfDoc.embedJpg(this.imageBuff);
            
            // let [convertX,convertY] = [x/1.3333333,pagePdf.getHeight()-(Number(y)/1.3333333)];;
            let [widthImg,heightImg] = [Number(width.replace('px', '')/1.333),Number(height.replace('px', '')/1.333)];
            let [widthPdf,heightPdf] = [pagePdf.getWidth(),pagePdf.getHeight()];
            let [convertX,convertY] = [x/1.333,(heightPdf-(y/1.3333333))-(heightImg/2)];

            if (convertX < 0) convertX = 0;
            if (convertY < 0) convertY = 0;
            if (convertX > widthPdf-(widthImg/2)) convertX = widthPdf - (widthImg/2);
            if (convertY > heightPdf-(heightImg/2)) convertY = heightPdf-(heightImg/2);

            let option = {
              x: Number(convertX),
              y: Number(convertY),
              width: Number(widthImg)/1.3333333,
              height: Number(heightImg)/1.3333333,
            };

            // alert(`${widthPdf}, ${heightPdf},${x},${y},${option.x},${option.y},${fullHeight}`);
            pagePdf.drawImage(imageJpeg,option);
          })
          
        }
      })

      // return;
      // Simpan PDF yang telah diedit ke file baru
      const editedPdfBytes = await pdfDoc.save();
      let formdata = new FormData();
      formdata.append('file_path', new Blob([editedPdfBytes], { type: 'application/pdf' }), 'file.pdf')
      axios.post(location.pathname, formdata)
        .then(ee =>{
          if(ee.data.url){
            location.href = ee.data.url
          }
        })
    },
    initDragable(id) {
      this.position[id] = { x: 0, y: 0 };
      interact(id)
        .resizable({
          edges: { top: true, left: true, bottom: true, right: true },
          listeners: {
            move: function (event) {
              let { x, y } = appPdf.position[id]

              x = (parseFloat(x) || 0) + event.deltaRect.left
              y = (parseFloat(y) || 0) + event.deltaRect.top

              Object.assign(event.target.style, {
                width: `${event.rect.width}px`,
                height: `${event.rect.height}px`,
                transform: `translate(${x}px, ${y}px)`
              })

              Object.assign(event.target.dataset, { x, y })
            }
          }
        })
        .draggable({
          modifiers: [
            interact.modifiers.restrictRect({
              restriction: '.canvasWrapper',
              endOnly: true
            })
          ],
          listeners: {
            move(event) {
              let position = appPdf.position[id]
              position.x += event.dx
              position.y += event.dy

              event.target.style.transform =
                `translate(${position.x}px, ${position.y}px)`
            },
          }
        })
    },
    openModal() {
      document.querySelector('#modalStamp form').reset();
      if(this.disabledStamp)return;
      this.modal.show();
    },
    uploadFile(event){
      event.preventDefault();
      const fileInput = document.querySelector('#modalStamp input[name=image]');
      const file = fileInput.files[0];
    
      if (file) {
          const reader = new FileReader();

          reader.onload = function(e) {
              const arrayBuffer = e.target.result;
              const fileURL = window.URL.createObjectURL(file);
              
              appPdf.imageUrl =  fileURL;
              appPdf.imageBuff =  arrayBuffer;
              appPdf.addStamp();
          };

          reader.readAsArrayBuffer(file);
      }
    },
    addStamp() {
      this.modal.hide();
      this.$refs.stampButton.classList.add('disabled')
      this.disabledStamp = true;

      let container = document.querySelector(`#viewerContainer .page[data-page-number="${this.page}"] .stamp-container`);
      if (!container) {
        let div = document.createElement('div');
        let page = this.page;
        div.classList.add('stamp-container', 'position-absolute');
        div.style.zIndex = 5;
        document.querySelector(`#viewerContainer .page[data-page-number="${page}"] .canvasWrapper`).insertAdjacentElement('afterbegin', div);
        container = document.querySelector(`#viewerContainer .page[data-page-number="${page}"] .stamp-container`);
        let stampHtml = `<div id="stamp-1" class="draggable border position-absolute" style="width:100px;height:100px;z-index:2">
        <img style="object-fit: fill;object-position: center;width: 100%;height: 100%;"
            src="${this.imageUrl}"
            alt="">
        </div>`;
        container.insertAdjacentHTML('beforeend', stampHtml);
        // }else{
      }
      // this.initDragable("#stamp-1")
      if (container.querySelector('#stamp-1')) {
        this.initDragable("#stamp-1")
      }
    },
  }
}).mount('#appPdf');