let deleteButtons = document.getElementsByClassName('delete_confirm');
let lastId = 0;
for (let i = 0; i < deleteButtons.length; i++) {
    lastId = parseInt((deleteButtons[i].id).replace('delete', ''));

    deleteButtons[i].addEventListener("click", function () {
        delete_confirm(this)
    })
}

let id = lastId;
function add_confirm() {
    console.log('add');

    id++;

    let flag = document.getElementById('flag').value + '.jpg';
    let denomination = document.getElementById('denomination').value;
    let category = document.getElementById('category').value;
    let material = document.getElementById('material').value;
    let year = document.getElementById('year').value;

    let data = {
        id: id,
        flag: flag,
        denomination: denomination,
        category: category,
        material: material,
        year: year
    };

    let formData = new FormData()
    formData.append('data', JSON.stringify(data))

    if (JSON.stringify(data)) {
        console.log('fetch to add');
        fetch('https://dev.juliandworzycki.pl/addData.php', {
            method: 'POST',
            body: formData
        })
            .then(() => {
                console.log('success');

                let row = document.createElement('tr');
                let flag = document.createElement('td');
                let denomination = document.createElement('td');
                let category = document.createElement('td');
                let material = document.createElement('td');
                let year = document.createElement('td');
                let button_delete = document.createElement('td');

                flag.innerHTML = data.flag;
                denomination.innerHTML = data.denomination;
                category.innerHTML = data.category;
                material.innerHTML = data.material;
                year.innerHTML = data.year;
                button_delete.className = 'delete_confirm';
                button_delete.id = "delete" + data.id;
                button_delete.innerHTML = '<img src="./img/delete.jpg" alt="delete">';
                button_delete.addEventListener("click", function () {
                    delete_confirm(this)
                })

                row.appendChild(flag);
                row.appendChild(denomination);
                row.appendChild(category);
                row.appendChild(material);
                row.appendChild(year);
                row.appendChild(button_delete);

                document.getElementById('main_table').appendChild(row);
            })
    }
}

function delete_confirm(element) {
    console.log('delete_confirm');

    console.log(element.id);

    let formData = new FormData()
    formData.append('data', JSON.stringify({ id: element.id }))

    if (JSON.stringify({ id: element.id })) {
        console.log('fetch to delete');
        fetch('https://dev.juliandworzycki.pl/deleteData.php', {
            method: 'POST',
            body: formData
        })
            .then(() => {
                console.log('Succesfuly deleted');
            })
    }

    element.parentElement.remove();
}