document.getElementById('add_confirm').addEventListener('click', function () {
    console.log('add');

    let flag = document.getElementById('flag').value;
    let denomination = document.getElementById('denomination').value;
    let category = document.getElementById('category').value;
    let material = document.getElementById('material').value;
    let year = document.getElementById('year').value;

    let data = {
        flag: flag,
        denomination: denomination,
        category: category,
        material: material,
        year: year
    };

    console.log(data);

    let formData = new FormData()
    formData.append('data', JSON.stringify(data))

    if (JSON.stringify(data)) {
        console.log('fetch');
        fetch('https://dev.juliandworzycki.pl/addData.php', {
            method: 'POST',
            body: formData
        })
            .then(() => {
                console.log('success');
                //location.reload();
            })
    }

});