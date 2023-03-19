let allFlags = [];
fetch('https://dev.juliandworzycki.pl/getFlags.php', {
    method: 'get',
})
    .then((response) => { return response.text() })
    .then((response) => {
        allFlags = JSON.parse(response).split(',');
    })

let allMaterials = [];
fetch('https://dev.juliandworzycki.pl/getMaterials.php', {
    method: 'get',
})
    .then((response) => { return response.text() })
    .then((response) => {
        allMaterials = JSON.parse(response).split(',');
    })

let deleteButtons = document.getElementsByClassName('delete_confirm');
let lastId = 0;
for (let i = 0; i < deleteButtons.length; i++) {
    lastId = parseInt((deleteButtons[i].id).replace('delete', ''));

    deleteButtons[i].addEventListener("click", function (e) {
        delete_confirm(this)
        e.stopPropagation();
    })
}

let flagButtons = document.getElementsByClassName('flags');
for (let i = 0; i < flagButtons.length; i++) {
    flagButtons[i].addEventListener("click", function (e) {
        row_change(this)
        e.stopPropagation();
    })
}

let isRowSelected = false;

let id = lastId;
function add_confirm() {
    console.log('add_confirm');

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
                console.log('Successfuly added');

                let row = document.createElement('tr');
                let flag = document.createElement('td');
                let denomination = document.createElement('td');
                let category = document.createElement('td');
                let material = document.createElement('td');
                let year = document.createElement('td');
                let button_delete = document.createElement('td');

                flag.innerHTML = '<img src="./flags/' + data.flag + '" alt="' + data.flag + '">';
                flag.className = 'flags';
                flag.id = "flag" + data.id;
                flag.addEventListener("click", function (e) {
                    row_change(this)
                    e.stopPropagation();
                })

                denomination.innerHTML = data.denomination;
                category.innerHTML = data.category;
                material.innerHTML = data.material;
                year.innerHTML = data.year;

                button_delete.className = 'delete_confirm';
                button_delete.id = "delete" + data.id;
                button_delete.innerHTML = '<img src="./img/delete.jpg" alt="delete">';
                button_delete.addEventListener("click", function (e) {
                    delete_confirm(this)
                    e.stopPropagation();
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

    let id = (element.id).replace('delete', '');

    let formData = new FormData()
    formData.append('data', JSON.stringify({ id: id }))

    if (JSON.stringify({ id: id })) {
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

let elementToChange
let oldElement;
function row_change(element) {
    console.log('row_change');
    elementToChange = element.parentElement;

    if (isRowSelected == false) {
        console.log('isRowSelected == false');

        oldElement = elementToChange.cloneNode(true)
        oldElement.className = 'oldElement';
        elementToChange.parentElement.insertBefore(oldElement, elementToChange);

        oldElement.style.display = 'none';
        oldElement = document.getElementById('oldElement');
        elementToChange.className = 'selected';

        //flag
        let oldFlag = (element.parentElement.children[0].children[0].alt).split(".")[0];
        element.parentElement.children[0].innerHTML = '';
        let select = document.createElement('select');
        for (let i = 0; i < allFlags.length; i++) {
            let option = document.createElement('option');
            option.value = allFlags[i];
            option.innerHTML = allFlags[i];

            if (oldFlag == allFlags[i]) {
                option.selected = true;
            }

            select.appendChild(option);
        }
        element.parentElement.children[0].append(select)

        //denominate
        let input = document.createElement('input');
        input.value = element.parentElement.children[1].innerHTML;
        element.parentElement.children[1].innerHTML = '';
        element.parentElement.children[1].append(input);

        //category
        input = document.createElement('input');
        input.value = element.parentElement.children[2].innerHTML;
        element.parentElement.children[2].innerHTML = '';
        element.parentElement.children[2].append(input);

        //materials
        let oldMaterial = element.parentElement.children[3].innerHTML;
        element.parentElement.children[3].innerHTML = '';
        select = document.createElement('select');
        for (let i = 0; i < allMaterials.length; i++) {
            let option = document.createElement('option');
            option.value = allMaterials[i];
            option.innerHTML = allMaterials[i];

            if (oldMaterial == allMaterials[i]) {
                option.selected = true;
            }

            select.appendChild(option);
        }
        element.parentElement.children[3].append(select)

        //year
        input = document.createElement('input');
        input.type = 'number';
        input.value = element.parentElement.children[4].innerHTML;
        element.parentElement.children[4].innerHTML = '';
        element.parentElement.children[4].append(input);

        //button
        element.parentElement.children[5].remove();
        let button = document.createElement('td');
        button.className = 'add_confirm';
        button.id = "add" + element.parentElement.children[0].id.replace('flag', '');
        button.innerHTML = '<img src="./img/confirm.png" alt="confirm">';
        button.addEventListener("click", function (e) {
            row_confirm(this)
            e.stopPropagation();
        })
        element.parentElement.appendChild(button);


        oldElement = element.parentElement;
    }

    isRowSelected = true;
}

document.getElementsByClassName('show')[0].addEventListener("click", (e) => {
    console.log('show');
    isRowSelected = false;
    e.stopPropagation();

    if (document.getElementsByClassName('selected')[0]) {
        document.getElementsByClassName('selected')[0].remove();
        document.getElementsByClassName('oldElement')[0].style.display = 'table-row';
        document.getElementsByClassName('oldElement')[0].children[0].addEventListener("click", function (e) {
            row_change(this)
            e.stopPropagation();
        })
        document.getElementsByClassName('oldElement')[0].children[5].addEventListener("click", function (e) {
            delete_confirm(this)
            e.stopPropagation();
        })
        document.getElementsByClassName('oldElement')[0].classList.remove('oldElement')
    }
})

function row_confirm(element) {
    console.log('row_confirm');

    let flag = element.parentElement.children[0].children[0].value;
    let denomination = element.parentElement.children[1].children[0].value;
    let category = element.parentElement.children[2].children[0].value;
    let material = element.parentElement.children[3].children[0].value;
    let year = element.parentElement.children[4].children[0].value;

    let originalElement = document.getElementsByClassName('oldElement')[0];
    originalElement.children[0].innerHTML = '<img src="./flags/' + flag + '.jpg" alt="' + flag + '">';
    originalElement.children[1].innerHTML = denomination;
    originalElement.children[2].innerHTML = category;
    originalElement.children[3].innerHTML = material;
    originalElement.children[4].innerHTML = year;

    originalElement.children[0].addEventListener("click", function (e) {
        row_change(this)
        e.stopPropagation();
    })
    originalElement.children[5].addEventListener("click", function (e) {
        delete_confirm(this)
        e.stopPropagation();
    })
    originalElement.classList.remove('oldElement')
    originalElement.style.display = 'table-row';

    element.parentElement.remove();

    isRowSelected = false;

    let data = {
        id: originalElement.children[5].id.replace('delete', ''),
        flag: flag,
        denomination: denomination,
        category: category,
        material: material,
        year: year
    }
    //console.log(data);

    let formData = new FormData()
    formData.append('data', JSON.stringify(data))
    if (JSON.stringify(data)) {
        console.log('fetch to update');
        fetch('https://dev.juliandworzycki.pl/updateDatabase.php', {
            method: 'POST',
            body: formData
        })
            .then(() => {
                console.log('Successfuly updated');
            })
    }
}