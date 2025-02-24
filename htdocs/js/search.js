function searchPets() {
    let species = document.getElementById("species").value;
    let name = document.getElementById("name").value;
    let status = document.getElementById("status").value;
    fetch(`https://x8ki-letl-twmt.n7.xano.io/api:iPSUkxr_/pet?species=${species}&name=${name}&status=${status}`)
    .then(response => response.json())
    .then(data => {
        let resultsDiv = document.getElementById("results");
        let statusColor = {
            1: 'green',
            2: '#cc6600',
            3: 'red'
        };
        resultsDiv.innerHTML = "";
        data.forEach(pet => {
            resultsDiv.innerHTML += `
                <div class='pet' onclick="window.location.href='reserve.php?id=${pet.id}'">
                    <img src='${pet.image.url}' alt='${pet.name}'>
                    <div class='pet-details'>
                        <strong>${pet.name}</strong>
                        <p style="color: ${statusColor[pet.petadoptionstatus_id] || 'black'};">
                            Status: ${pet._petadoptionstatus.displayText || 'Nieznana'}
                        </p>
                        Gatunek: ${pet.species}<br>
                        Wiek: ${pet.age} lat(a)<br>
                        Opis: ${pet.description.slice(0,100) + (pet.description.length > 100 ? '...' : '')}
                    </div>
                </div>`;
        });
    })
    .catch(error => console.error("Błąd pobierania danych:", error));
}