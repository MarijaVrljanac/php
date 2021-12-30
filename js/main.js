$('#addform').submit(function () {
    event.preventDefault();
    console.log("Dodaj je pokrenuto");
    const $form = $(this);
    const $input = $form.find('input,select,button,textarea');
    const serijalizacija = $form.serialize();
    console.log(serijalizacija);

    $input.prop('disabled', true);

    request = $.ajax({
        url: 'handler/add.php',
        type: 'post',
        data: serijalizacija
    });
    console.log(request);
   

    request.done(function (response, textStatus, jqXHR) {
        console.log(response);
        if (response === "Success") {
            alert("Uspešno dodato!");
            console.log("Uspešno dodavanje!");
            location.reload(true);
        }
        else {
            console.log("Tretman nije dodat" + response);
        }
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('Error message: ' + textStatus, errorThrown);
    });
});

function check() {
    document.getElementById("box").checked = true;
}




$('#btnDelete').click(function () {
    console.log("Brisanje");

    const checked = $('input[name=checked-donut]:checked');

    req = $.ajax({
        url: 'handler/delete.php',
        type: 'post',
        data: { 'tretmanID': checked.val() }
    });

    req.done(function (res, textStatus, jqXHR) {
        if (res == "Success") {
            checked.closest('tr').remove();
            alert('Uspešno izbrisano!');
            console.log('Deleted');
        } else {
            console.log("Nije izbrisano " + res);
            alert("Neuspešno brisanje!");

        }
        console.log(res);
    });



});




$('#btnPreview').click(function () {
    const checked = $('input[name=checked-donut]:checked');
    
    request = $.ajax({
        url: 'handler/get.php',
        type: 'post',
        data: { 'tretmanID': checked.val() },
        dataType: 'json'
    });
    console.log(request);

    request.done(function (response, textStatus, jqXHR) {
        console.log('Popunjena');
        //forma za profile modal nema polja sa ovim id-ijevima, dodati ih
       // $('#nazivTretmana').val(response[0]['nazivTretmana']);
       // console.log(response[0]['nazivTretmana']);

        // $('#adresaLokala').val(response[0]['adresaLokala'].trim());
        // console.log(response[0]['adresaLokala'].trim());
        $('#imePrezimeKozmeticara').text(response[0]['imePrezimeKozmeticara'].trim());
        console.log(response[0]['imePrezimeKozmeticara'].trim());

        $('#emailKozmeticara').text(response[0]['email'].trim());
        console.log(response[0]['email'].trim());

        // $('#datumIvreme').val(response[0]['datumIvreme']);
        // console.log(response[0]['datumIvreme']);

        // $('#cena').val(response[0]['cena'].trim());
        // console.log(response[0]['cena'].trim());

        $('#tretmanID').val(checked.val());

        // document.getElementById('nazivTretmana').innerHTML = response[0]['nazivTretmana'].trim();
        // document.getElementById('kozmeticar').innerHTML = "  " + response[0]['kozmeticar'].trim();
        // document.getElementById('adresaLokala').innerHTML = "  " + response[0]['adresaLokala'].trim();
        if (response[0]['nazivTretmana'].toUpperCase().includes("MANIKIR I PEDIKIR")) {//moraju svi da budu velikim slovima jer ide toUpperCase
            document.getElementById("Img").src = 'img/mani.png';
        } else if (response[0]['nazivTretmana'].toUpperCase().includes("TRETMAN LICA")) {//moraju svi da budu velikim slovima jer ide toUpperCase
            document.getElementById("Img").src = 'img/face.png';
        } else if (response[0]['nazivTretmana'].toUpperCase().includes("MASAZA")) { //moraju svi da budu velikim slovima jer ide toUpperCase
            document.getElementById("Img").src = 'img/massage.png';
        }   else if (response[0]['nazivTretmana'].toUpperCase().includes("SMINKANJE")) { //moraju svi da budu velikim slovima jer ide toUpperCase
            document.getElementById("Img").src = 'img/makeup.png';
        }
        else {
            document.getElementById("Img").src = 'http://placehold.it/100x100';
        }

        console.log(response);
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('The following error occurred: ' + textStatus, errorThrown);
    });

});







$('#btnChange').click(function () {
    const checked = $('input[name=checked-donut]:checked');
    //pristupa informacijama te konkretne forme i popunjava dijalog
    request = $.ajax({
        url: 'handler/get.php',
        type: 'post',
        data: { 'tretmanID': checked.val() },
        dataType: 'json'
    });


    request.done(function (response, textStatus, jqXHR) {
        console.log(response);
        console.log('Popunjena');
        $('#nazivTretmanaEdit').val(response[0]['nazivTretmana']);
        console.log(response[0]['nazivTretmana']);

        $('#adresaLokalaEdit').val(response[0]['adresaLokala'].trim());
        console.log(response[0]['adresaLokala'].trim());

        $('#kozmeticarEdit').val(response[0]['kozmeticar'].trim());
        console.log(response[0]['kozmeticar'].trim());

        //greska je bila i u imenu promenljive datumIvreme (ide veliko V )
        var datumVremeString = response[0]['datumIVreme'].trim();
        //datum koji citamo iz responsa je u obliku 2021-12-16 16:15:00
        //treba da prosledimo datum u ovom formatu 2021-12-16T16:15
        const myArray = datumVremeString.split(" ");
        var datumVremeUPravomFormatu = myArray[0]+"T"+myArray[1].slice(0,-3);//slice(0,-3) ce skinuti poslednja tri karaktera :00
        $('#datumIVremeEdit').val(  datumVremeUPravomFormatu); 
        console.log(datumVremeUPravomFormatu);

        $('#cenaEdit').val(response[0]['cena'].trim());
        console.log(response[0]['cena'].trim());

        $('#tretmanID').val(checked.val());

      /*  ovo ne treba, ovo je javascript kod koji radi isto sto i ovaj jquery kod iznad
        document.getElementById('nazivTretmanaEdit').value = response[0]['nazivTretmana'].trim();
        document.getElementById('adresaLokalaEdit').value = response[0]['adresaLokala'].trim();
        document.getElementById('kozmeticarEdit').value = response[0]['kozmeticar'].trim();
        document.getElementById('datumIvremeEdit').value = response[0]['datumIvreme'];
        document.getElementById('cenaEdit').value = response[0]['cena'].trim();
*/
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('The following error occurred: ' + textStatus, errorThrown);
    });

});


//dugme za slanje UPDATE zahteva nakon popunjene forme
$('#editform').submit(function () {
    event.preventDefault();
    console.log("Izmene");
    const $form = $(this);
    const $inputs = $form.find('input, select, button, textarea');
    const serializedData = $form.serialize();
    console.log(serializedData);
    $inputs.prop('disabled', true);

    // kreirati request za UPDATE handler
    request = $.ajax({
        url: 'handler/update.php',
        type: 'post',
        data: serializedData
    })
    console.log(request);
    request.done(function (response, textStatus, jqXHR) {
        console.log(response);
        console.log(textStatus);
        console.log(jqXHR);


        if (response === "Success") {
            console.log('Successfully changed');
            alert('Successfully changed');
            location.reload(true);
            $('#editform').reset;
        }
        else console.log('NOT changed /n' + response);
        console.log(response);
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
        console.error('The following error occurred: ' + textStatus, errorThrown);
    });


    $('#changeModal').modal('hide');
});


$('#btn-pretraga').click(function () {

    var para = document.querySelector('#myInput');
    console.log(para);
    var style = window.getComputedStyle(para);
    console.log(style);
    if (!(style.display === 'inline-block') || ($('#myInput').css("visibility") == "hidden")) {
        console.log('block');
        $('#myInput').show();
        document.querySelector("#myInput").style.visibility = "";
    } else {
        document.querySelector("#myInput").style.visibility = "hidden";
    }
});

$('#btnPreview').click(function () {
    $('#userViewModal').toggle();
});

$('#addButton').submit(function () {
    $('#addModal').modal('toggle');
    return false;
});

$('#btnChange').submit(function () {
    $('#changeModal').modal('toggle');
    return false;
});






