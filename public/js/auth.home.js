const modal = document.getElementById('modal');
    const modalImage = modal.getElementsByTagName('img')[0];
    const imageView = e=>{
        modal.style.display = "block";
        modalImage.src = e.src;
    }
    const closeModal = e=>{
        modal.style.display = "none";
    }

    const petitionPost = _id=>{
        let body = new URLSearchParams();
        body.append("id", _id);
        axios({
            method:"POST",
            url: "/auth/post/request",
            data:body,
            headers:{
                "Content-Type":"application/x-www-form-urlencoded"
            }
        }).then(response=>{
            if(response.data.message === ""){
                alert("Solicitud correcta");
                console.log(response.data.message);
                document.location.reload();
            }
            else
            {
                alert("Usted tiene una solicitud pendiente");
            }
        }).then(err=>{
            if(err) console.log(err);
        });
    }

    const deletePost = _id=>{
        let check = prompt("Escriba 'ACEPTAR' para eliminar", "");
        if(check==="ACEPTAR"){
            let body = new URLSearchParams();
            body.append("id", _id);
            axios({
                method:"POST",
                url: "/auth/post/delete",
                data:body,
                headers:{
                    "Content-Type":"application/x-www-form-urlencoded"
                }
            }).then(response=>{
                if(response.data.message === "Post delete"){
                    alert("Se a eliminado el post");
                    document.location.reload();
                }
                else
                {
                    alert("Error, el post no se pudo eliminar");
                }
            }).then(err=>{
                if(err) console.log(err);
            });  
        }
        else
        {
            alert("Confirmacion erronea, vuelva a intentar");
        }
    }

    const deleteRequest = _id=>{
        let check = prompt("Escriba 'ACEPTAR' para eliminar", "");
        if(check==="ACEPTAR"){
            let body = new URLSearchParams();
            body.append("id", _id);
            axios({
                method:"POST",
                url: "/auth/post/deleteRequest",
                data:body,
                headers:{
                    "Content-Type":"application/x-www-form-urlencoded"
                }
            }).then(response=>{
                if(response.data.message === "Request delete"){
                    alert("Se a eliminado el la solicitud");
                    document.location.reload();
                }
                else
                {
                    alert("Error, la solicitud no se pudo eliminar");
                }
            }).then(err=>{
                if(err) console.log(err);
            });  
        }
        else
        {
            alert("Confirmacion erronea, vuelva a intentar");
        }
    }