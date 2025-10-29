const inputs = document.querySelectorAll('input[type=checkbox]');
inputs.forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        if (checkbox.checked){
            checkbox.setAttribute('value', '1')
        } else{
            console.log('no')
            checkbox.setAttribute('value', '0')
        }
    });
});

const btnSync = document.getElementById('sync');
btnSync.addEventListener('click', (e)=>{
    e.preventDefault();
    // btnSync.disabled = true
    btnSync.textContent = 'Syncing...'

    let idsList = {};
    let i = 0;
    inputs.forEach((el)=>{
        if (el.getAttribute('value')==='1'){
            let parent = el.parentNode.parentNode;
            idsList[i] = parent.dataset.id
            i++;
        }
    })
    console.log(idsList)
    fetch('/syncWithDb', {
        method: 'post',
        body: new URLSearchParams(idsList).toString(),
        headers:{
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
        .then((response)=>response.json())
        .then((data)=>{
            console.log(data)
            btnSync.disabled = false
            btnSync.textContent = 'Sync'
            if (data.redirect){
                window.location.replace(data.redirect)
            }

        })
})

