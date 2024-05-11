const boton = document.querySelector('button');
boton.addEventListener('click', fetchDeDatos )

async function fetchDeDatos (){
    try{
        const data = await fetch('http://localhost/Proyectos/project/api.php?apicall=readusuario')
        .then(response => response.json())
        .then(json => {
            console.log(json)
            json.contenido.forEach(element => {
                const ul = document.createElement('ul')
                const li = document.createElement('li')
                li.textContent = element.fullname
                ul.appendChild(li)
                document.body.appendChild(ul)
                console.log(element) 
                
            });      
            
    })   
    }
    catch(error){
        console.log(error);
    }

    

}

