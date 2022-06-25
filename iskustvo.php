<?php
include 'header.php';
?>

<div class='container mt-2'>
    <h1 class='text-center text-dark'>
        Dosadašnje iskutvo kandidata
    </h1>
</div>

<div class='container'>
    <div class='row mt-2'>
        <div class='col-6'>
            <table class='table table-dark'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naziv</th>
                        <th>Izmeni</th>
                        <th>Obrisi</th>
                    </tr>
                </thead>
                <tbody id='iskustvo'>

                </tbody>
            </table>

        </div>

        <div class='col-6'>
            <h3 class="text-dark text-centar" id='naslov'>Imaš drugačije iskustvo? Opiši ga</h3>
            <form id='forma'>
                <div class='form-group'>
                    <label for="naziv">Ukratko iskustvo:</label>
                    <input required class="form-control" type="text" id="naziv">
                </div>
                <button class="btn btn-dark form-control" id="sacuvajK" type="submit">Sačuvaj</button>

            </form>
            <button id="vrati" hidden class="btn btn-secondary form-control mt-2" onclick="setIndex(-1)">Odustani
            </button>
        </div>



    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    let iskustvo = [];
    let selIndex = -1;

    $(function() {
        ucitajIskustvo();
        $('#forma').submit(e => {
            e.preventDefault();
            const naziv = $('#naziv').val();
            if (selIndex === -1) {
                $.post('server/iskustvo/create.php', {
                    naziv
                }).then(res => {
                    res = JSON.parse(res);
                    if (!res.status) {
                        alert(res.error);
                    } else {
                        ucitajIskustvo();
                    }
                })
            } else {
                $.post('server/iskustvo/update.php', {
                    naziv,
                    id: iskustvo[selIndex].id
                }).then(res => {
                    res = JSON.parse(res);
                    if (!res.status) {
                        alert(res.error);
                    } else {
                        setIskustvo(iskustvo.map((element, index) => {
                            if (index !== selIndex) {
                                return element;
                            }
                            return {
                                id: element.id,
                                naziv
                            };
                        }));
                        setIndex(-1);
                    }
                })
            }
        })
    })

    function ucitajIskustvo() {
        $.getJSON('server/iskustvo/read.php').then(res => {

            if (!res.status) {
                alert(res.error);
                return;
            }
            setIskustvo(res.kolekcija);
        })
    }

    function obrisi(id) {
        $.post('server/iskustvo/delete.php', {
            id
        }).then((res) => {
            res = JSON.parse(res);
            if (!res.status) {
                alert(res.error);
                return;
            }
            setIskustvo(iskustvo.filter((e) => e.id != id));

            setIndex(-1);
        })
    }

    function setIskustvo(val) {
        iskustvo = val;
        $('#iskustvo').html('');

        let index = 0;
        for (let i of iskustvo) {
            $('#iskustvo').append(`
                    <tr>
                        <td>${i.id}</td>
                        <td>${i.naziv}</td>
                        <td>
                            <button class='btn btn-light form-control' onClick="setIndex(${index})" >Izmeni</button>
                        </td>
                        <td>
                            <button class='btn btn-danger form-control' onClick="obrisi(${i.id})">Obrisi</button>
                        </td>
                    </tr>
                `);
            index++;
        }
    }

    function setIndex(val) {
        selIndex = val
        if (selIndex === -1) {
            $('#naslov').html('Kreiraj iskustvo');
            $('#naziv').val('');

        } else {
            $('#naslov').html('Izmeni iskustvo')
            $('#naziv').val(iskustvo[selIndex].naziv);
        }
        $('#vrati').attr('hidden', selIndex === -1)
    }
</script>
<?php
include 'footer.php';
?>