fetch("https://www.cmuccdc.org/api/ccdc_2/DBhealthzone/1")
.then(response => response.json())
.then(data => {
    console.log('Success:', data);
    document.getElementById('result-api').innerHTML = JSON.stringify(data);
})
.catch((error) => {
    console.error('Error:', error)
})