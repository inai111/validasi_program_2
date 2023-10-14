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
      fileUrl: location.pathname.replace('/edit', ''),
      container:document.querySelector(`#containerPdf`),
      page: 1,
      pageMax: 0,
      pdfRead: {},
      pdfViewOption: {},
      stampIsDragging: 0,
      position: {},
      pagesPdf: []
    }
  },
  mounted() {
    this.initPdfView();
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

      // const container = document.getElementById("containerPdf");
      
      const container = document.getElementById("viewerContainer");
      
      this.pageMax = pdfDocument._pdfInfo.numPages
      
      // const pagePdf = await pdfDocument.getPage(this.page);
      
      
      // Creating the page view with default parameters.
      // const pdfPageView = new PDFViewer({
      //   container,
      //   id: this.page,
      //   scale: 1.0,
      //   defaultViewport: pagePdf.getViewport({ scale: 1.0 }),
      //   eventBus,
      // });
      const pdfPageView = new PDFViewer({
        container,
        eventBus,
      });

      // // Associate the actual page with the view, and draw it.
      pdfPageView.setDocument(pdfDocument);
      // return pdfPageView.draw();
    },
    async editText() {
      // Baca file PDF yang akan diedit
      const filePath = location.pathname.replace('/edit', '');
      const filePdf = await fetch(filePath).then(res => res.arrayBuffer())
      const pdfBuffer = filePdf;
      const pdfDoc = await PDFDocument.load(pdfBuffer);

      // Halaman yang akan diedit (indeks dimulai dari 0)
      const pagesToEdit = 0;

      // Loop melalui halaman yang akan diedit
      const page = pdfDoc.getPages()[pagesToEdit];

      // Tambahkan teks atau elemen lain ke halaman jika diperlukan
      // Misalnya, untuk menambahkan teks ke halaman:
      page.drawText('Ini adalah teks yang ditambahkan ke halaman.', {
        x: 570,
        y: 50,
        size: 12,
        color: rgb(0, 0, 0), // Warna teks hitam
      });

      // Simpan PDF yang telah diedit ke file baru
      const editedPdfBytes = await pdfDoc.save();
      let formdata = new FormData();
      formdata.append('file_path', new Blob([editedPdfBytes], { type: 'application/pdf' }), 'file.pdf')
      axios.post('/file/60fcf12a-5dac-11ee-8e02-00ff6b16807a/edit', formdata)
        // fetch('/file/60fcf12a-5dac-11ee-8e02-00ff6b16807a/edit',{
        //   method:"PUT",
        //   body:formdata,
        //   headers:{
        //     // "x-csrf-token":document.querySelector(`meta[name=csrf-token]`).content,
        //     'content-type':"multipart/form-data"
        //   }
        // })
        // .then(ee=>ee.json())
        .then(ee => console.log(ee))
      // await downloadFn(editedPdfBytes, 'ama.pdf', 'application/pdf')
      // await fs.writeFile('nama_file_diedit.pdf', editedPdfBytes);
    },
    startDragging(event) {
      this.stampIsDragging = 1;
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
              restriction: '.position-relative',
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
    addStamp(event) {

      console.log(event, this.$refs)
    }
  }
}).mount('#appPdf');