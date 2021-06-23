const Aprovar = _id => {
    let body = new URLSearchParams();
    body.append("id", _id);
    body.append("type", "apr");
    axios({
        method: "POST",
        url: "/auth/post/applicants/aprovar",
        data: body,
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        }
    }).then(response => {
        if (response.data.message === "Aprove") {
            alert("Se aprobo la solicitud");
            document.location.reload();
        }
        else {
            alert("Error, la solicitud no se pudo eliminar");
        }
    }).then(err => {
        if (err) console.log(err);
    });
}

const Denegar = _id => {
    let check = prompt("Escriba 'ACEPTAR' para eliminar", "");
    if (check === "ACEPTAR") {
        let body = new URLSearchParams();
        body.append("id", _id);
        body.append("type", "del");
        axios({
            method: "POST",
            url: "/auth/post/applicants/aprovar",
            data: body,
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            }
        }).then(response => {
            if (response.data.message === "Delete") {
                alert("Se a eliminado el la solicitud");
                document.location.reload();
            }
            else {
                alert("Error, la solicitud no se pudo eliminar");
            }
        }).then(err => {
            if (err) console.log(err);
        });
    }
    else {
        alert("Confirmacion erronea, vuelva a intentar");
    }
}