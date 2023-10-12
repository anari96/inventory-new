    <script>
        const tableSparepart = document.getElementById('table-sparepart');
        const tableSparepartShow = document.getElementById('table-sparepart-list');
        const tableDetail = document.getElementById('table-detail-item');
        const itemDeleteButton = document.querySelectorAll(".item-delete");
        const itemDiskonInput = document.querySelectorAll(".item-diskon");
        const itemQtyInput = document.querySelectorAll(".qty");
        const uangBayarInput = document.getElementById("uang_bayar");

        let pageChangeNextButton = document.getElementById("page-change-next");
        let pageChangePreviousButton = document.getElementById("page-change-previous");
        let pageChangeButton = document.querySelectorAll(".page-change");
        let currentPageButton = document.getElementById("current-page");

        let itemId = document.querySelectorAll(".item_id");

        // console.log(itemId);

        const numberFormat = new Intl.NumberFormat({ style: 'currency' });

        let itemIdArray = [];

        let previousPage = 1;
        let nextPage = 1;
        let currentPage = 1;
        let lastPage = 1;

        pageChangeButton.forEach((e) => {
            e.addEventListener("click", function (event){
               // console.log(this.dataset.page);
               tableShowData(this.dataset.page);
            });
        });

        tableSparepartShow.addEventListener("click", function () {
            tableShowData(currentPage);
        });


        //memunculkan data pada modal table item
        function tableShowData(page){
            currentPage = parseInt(page);

            fetch("{{route('get-item')}}?page="+page,{
                method: "GET"
            })
            .then(
                (response) => {
                    return response.json();
                }
            )
            .then((data) => {
                if(currentPage == 1){
                    previousPage = currentPage;
                    nextPage = currentPage + 1;
                }else if(currentPage > 1 && currentPage < data.data.last_page){
                    previousPage = currentPage - 1;
                    nextPage = currentPage + 1;
                }else if (currentPage == parseInt(data.data.last_page)){
                    previousPage = currentPage - 1;
                    nextPage = currentPage;
                }

                console.log("currentPage = " + currentPage + " previousPage = " + previousPage + " nextPage = " + nextPage + " lastPage = "+ data.data.last_page);

                pageChangeNextButton.dataset.page = nextPage;
                pageChangePreviousButton.dataset.page = previousPage;
                currentPageButton.innerHTML = currentPage;

                const rowCount = tableSparepart.querySelector('tbody');

                while(rowCount.firstChild){
                    rowCount.removeChild(rowCount.firstChild);
                }

                let items = data.data;
                items.data.forEach(item => {
                    let namaSparepartText = document.createTextNode(item.nama_item);
                    let hargaJualText = document.createTextNode(numberFormat.format(item.harga_item));
                    let hargaBeliText = document.createTextNode(numberFormat.format(item.biaya_item));
                    let stokText = document.createTextNode(item.stok);

                    let pilihButtonText = document.createTextNode(`Pilih`);

                    let pilihButton = document.createElement("button");
                    pilihButton.classList.add('btn','btn-primary','item-add');
                    // pilihButton.setAttribute('data-id', item.id);
                    pilihButton.setAttribute('type', "button");
                    pilihButton.dataset.id = item.id;
                    pilihButton.appendChild(pilihButtonText);

                    let jumlahInput = document.createElement("input");
                    jumlahInput.setAttribute('type', "number");
                    jumlahInput.setAttribute('value', 0);
                    jumlahInput.setAttribute('max', item.stok == null ? 0 : item.stok);
                    jumlahInput.setAttribute('min', 0);
                    jumlahInput.classList.add('form-control','jumlah-input');

                    let row = tableSparepart.querySelector("tbody").insertRow(-1);
                    let namaSparepart = row.insertCell(0);
                    let hargaJual = row.insertCell(1);
                    let hargaBeli = row.insertCell(2);
                    let stok = row.insertCell(3);
                    let jumlah = row.insertCell(4);
                    let pilih = row.insertCell(5);

                    namaSparepart.appendChild(namaSparepartText);
                    hargaJual.appendChild(hargaJualText);
                    hargaBeli.appendChild(hargaBeliText);
                    stok.appendChild(stokText);
                    jumlah.appendChild(jumlahInput);
                    pilih.appendChild(pilihButton);

                    addEventPilih(pilihButton);
                });
            });

        }

        //menambahkan item ke dalam detail penjualan
        function addEventPilih(element){
            element.addEventListener('click', function(event){

                console.log("test");

                let jumlah = this.parentElement.parentElement.childNodes[4];

                let jumlahValue = jumlah.querySelector(".jumlah-input").value;

                fetch("{{route('get-item')}}?search=" + this.dataset.id,{
                    method: "GET"
                })
                .then(
                    (response) => {
                        return response.json();
                    }
                )
                .then((data) => {

                    let items = data.data;
                    items.data.forEach(item => {
                        if(jumlahValue > 0){
                            addDetailBarangRow();
                        }

                        function addDetailBarangRow()
                        {
                            //new text element
                            let namaSparepartText = document.createTextNode(item.nama_item);
                            let hargaJualText = document.createTextNode(numberFormat.format(item.harga_item));
                            let hargaBeliText = document.createTextNode(numberFormat.format(item.biaya_item));
                            let jumlahText = document.createTextNode(jumlahValue);
                            let subTotalText = document.createTextNode(numberFormat.format(item.harga_item * jumlahValue));
                            let hapusButtonText = document.createTextNode("X");

                            let hapusButton = document.createElement("button");
                            hapusButton.classList.add("btn","btn-danger","item-delete");
                            hapusButton.appendChild(hapusButtonText);
                            hapusButton.setAttribute('type', "button");

                            let diskonInput = document.createElement("input");
                            diskonInput.classList.add("item-diskon");
                            diskonInput.setAttribute("name", "diskon[]");
                            diskonInput.setAttribute("type", "number");
                            diskonInput.setAttribute("min", 0);
                            diskonInput.setAttribute("value", 0);

                            //hidden input for form request
                            let jumlahInput = document.createElement("input");
                            jumlahInput.classList.add("qty");
                            jumlahInput.setAttribute('name', "jumlah[]");
                            jumlahInput.setAttribute('type', "number");
                            jumlahInput.setAttribute('max', item.stok);
                            jumlahInput.setAttribute('min', 0);
                            jumlahInput.setAttribute('value', jumlahValue);
                            // jumlahInput.setAttribute('hidden', true);

                             //hidden input for form request
                            let idInput = document.createElement("input");
                            idInput.setAttribute('name', "id[]");
                            idInput.classList.add("item_id");
                            idInput.setAttribute('type', "text");
                            idInput.setAttribute('value', item.id);
                            idInput.setAttribute('hidden', true);

                            let hargaInput = document.createElement("input");
                            hargaInput.setAttribute('name', "harga[]");
                            hargaInput.classList.add("harga");
                            hargaInput.setAttribute('type', "number");
                            hargaInput.setAttribute('value', item.harga_item);
                            hargaInput.setAttribute('hidden', true);

                            let row = tableDetail.querySelector("tbody").insertRow(-1);
                            let namaSparepart = row.insertCell(0);
                            let hargaBeli = row.insertCell(1);
                            let jumlah = row.insertCell(2);
                            let hargaJual = row.insertCell(3);
                            let subTotal = row.insertCell(4);
                            subTotal.classList.add("subTotal");
                            let hapus = row.insertCell(5);

                            namaSparepart.appendChild(namaSparepartText);
                            hargaJual.appendChild(hargaJualText);
                            hargaBeli.appendChild(diskonInput);
                            subTotal.appendChild(subTotalText);
                            // jumlah.appendChild(jumlahText);
                            jumlah.appendChild(jumlahInput);
                            jumlah.appendChild(idInput);
                            jumlah.appendChild(hargaInput);
                            hapus.appendChild(hapusButton);

                            let detail = [item.id,jumlahValue];

                            addEventHapus(hapusButton);
                            addEventDiskon(diskonInput);
                            addEventQty(jumlahInput);
                            countGrandTotal();
                        }
                    });
                });


            })
        }

        function addEventHapus(element){
           element.addEventListener("click", function(event){
                this.parentElement.parentElement.remove();
                countGrandTotal();
            });
        }

        function addEventDiskon(e){
            countSubTotal(e);
        }

        function addEventQty(e){
            countSubTotal(e);
        }

        itemDeleteButton.forEach( (e)=>{
            e.addEventListener("click", function(event){
                this.parentElement.parentElement.remove();
                countGrandTotal();
            });
        } );

        itemDiskonInput.forEach( (e)=>{
            countSubTotal(e);
        } );

        itemQtyInput.forEach( (e)=>{
            countSubTotal(e);
        } );

        uangBayarInput.addEventListener("input", function(event){
           countGrandTotal();
        });

        function countSubTotal(e){
            e.addEventListener("input", function(event){
               let qty = this.parentElement.parentElement.children[2].children[0];
               let hargaItem = this.parentElement.parentElement.children[3];
               let subTotalElement = this.parentElement.parentElement.children[4];
               let diskonInput = this.parentElement.parentElement.children[1].children[0];

               const harga = this.parentElement.parentElement.children[2].children[2];

               let hargaDiskon = Math.max(parseFloat(harga.value) - diskonInput.value,0) ;

               // hargaItem.textContent = hargaDiskon;

               let subtotal = hargaDiskon * qty.value;

               subTotalElement.textContent = numberFormat.format(subtotal);

                countGrandTotal();
            });
        }

        function countGrandTotal(){
            let kembaliInput = document.getElementById("kembali");
            let uangBayarInput = document.getElementById("uang_bayar");
            let subTotal = document.querySelectorAll(".subTotal");
            let grandTotal = document.querySelector("#grandTotal");
            let grandTotalValue = 0;
            let kembaliValue = 0;
            subTotal.forEach((element) => {
                subTotalValue = parseFloat(element.textContent.replaceAll(",",""));
                grandTotalValue += subTotalValue;
            });

            grandTotal.textContent = numberFormat.format(grandTotalValue);
            // kembaliValue = Math.max(0,uang_bayar.value - parseInt(grandTotalValue));
            kembaliValue = uang_bayar.value - parseInt(grandTotalValue);
            if(kembaliValue < 0 ){
                kembaliInput.value = "Uang Bayar Tidak Cukup";
            }else if (kembaliInput >= 0){
                kembaliInput.value = numberFormat.format(parseInt(kembaliValue));
            }else{
                kembaliInput.value = numberFormat.format(parseInt(kembaliValue));
            }
            console.log(numberFormat.format(parseInt(kembaliValue)));
        }

        countGrandTotal();
    </script>
