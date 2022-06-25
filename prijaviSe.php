<?php
    include 'header.php';
?>

<div class='container mt-2 mb-5'>
    <h1 class='text-center text-dark'>
        Unesi svoje lične podatke
    </h1>
    <div class='row mt-2 d-flex justify-content-center'>
        <div class='col-7'>
            <form id='forma'>
                <div class='form-group'>
                    <label for="naziv">Ime i prezime</label>
                    <input required name="naziv" class="form-control" type="text" id="naziv">
                </div>
                <div class='form-group'>
                    <label for="godiste">Godište</label>
                    <input required name="godiste" class="form-control" type="number" min="1" id="godiste">
                </div>

                <div class='form-group'>
                    <label for="kategorija">Kategorija</label>
                    <select required name='kategorija' class="form-control" id="kategorija"></select>
                </div>
                <div class='form-group'>
                    <label for="iskustvo">Iskustvo</label>
                    <select required name="iskustvo" class="form-control" id="iskustvo"></select>
                </div>
                <div class='form-group'>
                    <label for="slika">Slika</label>
                    <input required name="slika" class="form-control-file" type="file" id="slika">
                </div>
                <div class='form-group'>
                    <label for="napomena">Napomena</label>
                    <textarea required name="napomena" class="form-control" type="number" id="napomena"></textarea>
                </div>
                <button type="submit" class="btn btn-primary form-control" id="dodaj">Prosledi</button>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function () {
        ucitajOptions('server/kategorija/read.php', 'kategorija');
        ucitajOptions('server/iskustvo/read.php', 'iskustvo');
        $('#forma').submit(e => {

            e.preventDefault();

            const naziv = $('#naziv').val();
            const godiste = $('#godiste').val();
            const kategorija = $('#kategorija').val();
            const iskustvo = $('#iskustvo').val();
            const napomena = $('#napomena').val();
            const slika = $("#slika")[0].files[0];
            const fd = new FormData();
            fd.append("slika", slika);
            fd.append("naziv", naziv);
            fd.append("napomena", napomena);
            fd.append("godiste", godiste);
            fd.append("kategorija", kategorija);
            fd.append("iskustvo", iskustvo);
            $.ajax(
                {
                    url: "./server/kandidati/create.php",
                    type: 'post',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        data = JSON.parse(data);
                        if (!data.status) {
                            alert(data.error);
                        }

                    },

                }
            )
        })
    })

    function ucitajOptions(url, htmlElement) {
        $.getJSON(url).then(res => {
            if (!res.status) {
                alert(res.error);
                return;
            }
            for (let element of res.kolekcija) {
                $('#' + htmlElement).append(`
                    <option value="${element.id}">
                        ${element.naziv}
                        </option>
                `)
            }
        })
    }

</script>

<?php
    include 'footer.php';
?>