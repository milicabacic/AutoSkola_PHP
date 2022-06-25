<?php
    include 'header.php';
?>

<div class='container mt-2'>
    <h1 class='text-center text-dark'>
        Do sada prijavljeni kandidati
    </h1>
    <div class="row mt-2">
        <div class="col-3">
            <select onchange="render()" class="form-control" id="sort">
                <option value="-1">Od najmladjeg kandidata</option>
                <option value="1">Od najstarijeg kandidata</option>
            </select>
        </div>
        <div class="col-6">
            <input onchange="render()" class="form-control" type="text" id="search" placeholder="search...">
        </div>
        <div class="col-3">
            <select onchange="render()" class="form-control" id="kategorije">
                <option value="0">Sve kategorije</option>
            </select>
        </div>
    </div>
    <div id='podaci'>

    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    let kandidati = [];
    let kategorije = [];
    let iskustva = [];
    $(function () {
        $.getJSON('server/kategorija/read.php').then((res => {
            if (!res.status) {
                alert(res.error);
                return;
            }
            kategorije = res.kolekcija;
            for (let kat of kategorije) {
                $('#kategorije').append(`
                <option value="${kat.id}"> ${kat.naziv}</option>
                `)
            }
        }))
            .then(() => {
                return $.getJSON('server/iskustvo/read.php')

            }).then((res => {
                if (!res.status) {
                    alert(res.error);
                    return;
                }
                iskustva = res.kolekcija;

            }))
            .then(ucitajKandidate)


    })


    function ucitajKandidate() {
        $.getJSON('server/kandidati/read.php', (res => {
            if (!res.status) {
                alert(res.error);
                return;
            }
            kandidati = res.kolekcija || [];
            render();
        }))
    }

    function render() {
        const search = $('#search').val();
        const sort = Number($('#sort').val());
        const kat = Number($('#kategorije').val());
        const niz = kandidati.filter(element => {
            return (kat == 0 || element.kategorija == kat) && element.naziv.includes(search)
        }).sort((a, b) => {
            return (a.godiste > b.godiste) ? sort : 0 - sort;
        });
        let red = 0;
        let kolona = 0;
        $('#podaci').html(`<div id='row-${red}' class='row mt-2'></div>`)
        for (let kandidat of niz) {
            if (kolona === 4) {
                kolona = 0;
                red++;
                $('#podaci').append(`<div id='row-${red}' class='row mt-2'></div>`)
            }
            $(`#row-${red}`).append(
                `
                        <div class='col-3 pt-2 bg-white'>
                            <div class="card" >
                                <img class="card-img-top" src="${kandidat.slika}" alt="Card image cap">
                                <div class="card-body">
                                    <h6 class="card-title">Naziv: ${kandidat.naziv}</h6>
                                    <h6 class="card-title">Godiste: ${kandidat.godiste}</h6>
                                    <h6 class="card-title">Kategorija: ${kategorije.find(element => element.id === kandidat.kategorija).naziv}</h6>
                                    <h6 class="card-title">Iskustvo: ${iskustva.find(element => element.id === kandidat.iskustvo).naziv}</h6>
                                   <b>Napomena:</b>
                                    <p class="card-text">${kandidat.napomena}</p>
                                </div>
                                <div class="card-footer ">
                                    <button class='btn btn-danger form-control' onClick="obrisi(${kandidat.id})">Obriši</button>
                                </div>
                            </div>
                        </div>
                    `
            )
            kolona++;
        }

    }
    function obrisi(id) {
        id = Number(id);
        $.post('server/kandidati/delete.php', { id }).then(res => {
            res = JSON.parse(res);
            if (!res.status) {
                alert(res.error);
                return;
            }

            kandidati = kandidati.filter(element => element.id != id);
            render();
        })
    }
</script>

<?php
    include 'footer.php';
?>