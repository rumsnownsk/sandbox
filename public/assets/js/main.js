const inputs = document.querySelectorAll('input[type=checkbox]');
inputs.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        if (checkbox.checked) {
            checkbox.setAttribute('value', '1')
        } else {
            console.log('no')
            checkbox.setAttribute('value', '0')
        }
    });
});

const btnSync = document.getElementById('sync');
// btnSync.addEventListener('click', (e)=>{
//     e.preventDefault();
//     // btnSync.disabled = true
//     btnSync.textContent = 'Syncing...'
//
//     let idsList = {};
//     let i = 0;
//     inputs.forEach((el)=>{
//         if (el.getAttribute('value')==='1'){
//             let parent = el.parentNode.parentNode;
//             idsList[i] = parent.dataset.id
//             i++;
//         }
//     })
//     console.log(idsList)
//     fetch('/syncWithDb', {
//         method: 'post',
//         body: new URLSearchParams(idsList).toString(),
//         headers:{
//             'Content-Type': 'application/x-www-form-urlencoded'
//         }
//     })
//         .then((response)=>response.json())
//         .then((data)=>{
//             console.log(data)
//             btnSync.disabled = false
//             btnSync.textContent = 'Sync'
//             if (data.redirect){
//                 window.location.replace(data.redirect)
//             }
//         })
// })

const select_wh = document.querySelector('#select_wh')
const select_ctg = document.querySelector('#select_categories')


let wh_id = '';
let ctg_id = '';
select_wh.addEventListener('change', (e) => {
    wh_id = e.target.value;
})
select_ctg.addEventListener('change', (e) => {
    ctg_id = e.target.value;
    let params = {
        wh_id: wh_id,
        ctg_id: ctg_id
    }

    fetch('/getcategories', {
        method: 'post',
        body: new URLSearchParams(params).toString(),
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
    })
        .then((response)=>response.json())
        .then((data)=>{
            const tableProducts = document.getElementById('tbody_products');

            const tableBodyProducts = tableProducts.getElementsByTagName('tbody')[0]

            console.log()
            if (tableBodyProducts.innerHTML !== ""){
                tableBodyProducts.innerHTML = ""
            }
            tableBodyProducts.insertAdjacentHTML('beforeend', data.tbody_products)

             console.log(data)
        })

})


