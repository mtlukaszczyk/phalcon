function logIn() {

    const user = $('#login').val();
    const password = $('#pass').val();

    $.ajax({
        url: baseUrl + '/' + langSymbol + '/user/login/',
        method: "POST",
        dataType: 'json',
        data: {
            login: user,
            password: password
        }
    }).done(function (result) {
        window.location.reload();

    });
}

function logOut() {

    $.ajax({
        url: baseUrl + '/' + langSymbol + '/user/logout/',
        method: "POST",
        dataType: 'json',
    }).done(function (result) {
        window.location.reload();

    });
}