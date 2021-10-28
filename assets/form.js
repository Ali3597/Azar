import './styles/form.css';

console.log("hello");
//Supression des photos
document.querySelectorAll('[data-delete]').forEach(a=>{
    a.addEventListener('click',e=>{
        e.preventDefault()
        fetch(a.getAttribute('href'),{
            method: 'DELETE',
            headers:{
                'X-Requested-With' :'XMLHttpRequest',
                'Content-Type' : 'application/json'
            },
            body: JSON.stringify({'_token':a.dataset.token})
        })
        .then(response=> response.json())
        .then(data=>{
            if (data.success){
                    a.parentNode.parentNode.removeChild(a.parentNode);
            }else{

                alert(data.error)
            }
        })
        .catch( err => {
            console.log("ici")
            alert(err);
          })  
    })
})



