function maintenanceInfos(id) {
    return new Promise((resolve, reject) => {
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", `./php-scripts/maintenance-infos.php?id=${id}`, true);
        xmlhttp.onload = () => {
            if (xmlhttp.status === 200) {
                let data = JSON.parse(xmlhttp.responseText);
                resolve(data);
            } else {
                reject("Erreur lors de la requête AJAX");
            }
        };
        xmlhttp.onerror = () => {
            reject("Erreur lors de la requête AJAX");
        };
        xmlhttp.send();
    });
}

function addTeam() {
    return new Promise((resolve, reject) => {
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST", `./php-scripts/add_team.php`, true);
        xmlhttp.setRequestHeader("Content-Type", "application/json");

        xmlhttp.onload = () => {
            if (xmlhttp.status === 200) {
                let response = JSON.parse(xmlhttp.responseText);
                resolve(response);
                location.reload();
            } else {
                reject("Erreur lors de la requête AJAX");
            }
        };

        xmlhttp.onerror = () => {
            reject("Erreur lors de la requête AJAX");
        };

        xmlhttp.send();
    });
}

function deleteTeam(id) {
    return new Promise((resolve, reject) => {
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", './php-scripts/delete_team.php?id=' + id, true);
        xmlhttp.setRequestHeader("Content-Type", "application/json");

        xmlhttp.onload = () => {
            if (xmlhttp.status === 200) {
                let response = JSON.parse(xmlhttp.responseText);
                resolve(response);
                location.reload();
            } else {
                reject("Erreur lors de la requête AJAX");
            }
        };

        xmlhttp.onerror = () => {
            reject("Erreur lors de la requête AJAX");
        };

        xmlhttp.send();
    });
}

function housingInfos(id) {
    return new Promise((resolve, reject) => {
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", `./php-scripts/housing-infos.php?id=${id}`, true);
        xmlhttp.onload = () => {
            if (xmlhttp.status === 200) {
                let data = JSON.parse(xmlhttp.responseText);
                resolve(data);
            } else {
                reject("Erreur lors de la requête AJAX");
            }
        };
        xmlhttp.onerror = () => {
            reject("Erreur lors de la requête AJAX");
        };
        xmlhttp.send();
    });
}

function searchInfos(prompt) {
    return new Promise((resolve, reject) => {
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", `./php-scripts/maintenance_search_user.php?prompt=${prompt}`, true);
        xmlhttp.onload = () => {
            if (xmlhttp.status === 200) {
                let data = JSON.parse(xmlhttp.responseText);
                resolve(data);
            } else {
                reject("Erreur lors de la requête AJAX");
            }
        };
        xmlhttp.onerror = () => {
            reject("Erreur lors de la requête AJAX");
        };
        xmlhttp.send();
    });
}

function shutPopup(e) {
    if (e.target.className == popUp.parentNode.className) {
        popUp.parentNode.remove();
    }
}

function openMaintenanceInfos(id) {
    maintenanceInfos(id)
        .then(data => {
            let maintenance = document.createElement('input');
            maintenance.type = "hidden";
            maintenance.name = "id";
            maintenance.value = data.id;

            let housing = document.createElement('p');
            housing.innerText = `Identifiant du Logement : ${data.housing_id}`;

            let dueDate = document.createElement('p');
            dueDate.innerText = `Date de la location : ${data.due_date}`;

            let teamLabel = document.createElement('label');
            teamLabel.for = "team_id";
            teamLabel.classList.add("form-label");
            teamLabel.innerText = "Identifiant de l'Équipe";
            let team = document.createElement('input');
            team.type = "number";
            team.min = "1";
            team.name = "team_id";
            if (data.team_id !== null) {
                team.value = data.team_id;
            } else {
                team.placeholder = "Sélectionner un identifiant";
            }
            team.classList.add("form-input");

            let maintenanceDateLabel = document.createElement('label');
            maintenanceDateLabel.for = "maintenance_date";
            maintenanceDateLabel.classList.add("form-label");
            maintenanceDateLabel.innerText = "Planifier l'entretien";
            let maintenanceDate = document.createElement('input');
            maintenanceDate.type = "date";
            let minDate = new Date();
            maintenanceDate.min = minDate.toISOString().split("T")[0];
            let maxDate = new Date(data.due_date);
            maxDate.setDate(maxDate.getDate() - 1);
            maintenanceDate.max = maxDate.toISOString().split("T")[0];
            maintenanceDate.name = "maintenance_date";
            if (data.maintenance_date !== null) {
                maintenanceDate.value = data.maintenance_date
            }
            maintenanceDate.classList.add("form-input");

            let noteLabel = document.createElement('label');
            noteLabel.for = "note_content";
            noteLabel.classList.add("form-label");
            noteLabel.innerText = "Ajouter ou modifier la note";
            let note = document.createElement('textarea');
            note.name = "note_content";
            switch (data.note_content) {
                case null:
                    note.placeholder = "Laissez une note pour l'équipe d'entretien";
                    break;
                default:
                    note.innerText = data.note_content;
                    break;
            }
            note.classList.add("form-input");

            let submit = document.createElement('input');
            submit.type = "submit";
            submit.value ="Planifier l'entretien";
            submit.classList.add("form-submit");

            let popUpForm = document.createElement('form');
            popUpForm.action = "./php-scripts/update_maintenance.php";
            popUpForm.method = "POST";
            popUpForm.classList.add("popup-element");

            popUpForm.appendChild(maintenance);
            popUpForm.appendChild(housing);
            popUpForm.appendChild(dueDate);
            popUpForm.appendChild(teamLabel);
            popUpForm.appendChild(team);
            popUpForm.appendChild(maintenanceDateLabel);
            popUpForm.appendChild(maintenanceDate);
            popUpForm.appendChild(noteLabel);
            popUpForm.appendChild(note);
            popUpForm.appendChild(submit);

            popUp = popUpForm;

            let dashboardPopUp = document.createElement('div');
            dashboardPopUp.classList.add("dashboard-popup");

            dashboardPopUp.appendChild(popUp);

            dashboardLeft.insertBefore(dashboardPopUp, dashboardLeft.firstChild);
            dashboardLeft.addEventListener('click', shutPopup);
        })
        .catch(error => {
            console.error(error);
        });
}

function openHousingInfos(id) {
    housingInfos(id)
        .then(data => {
            
            let popUpElement = document.createElement('div');
            popUpElement.classList.add('popup-element');
            popUpElement.innerHTML = `
                <h3>Logement ${data.id} </h3>
                <h4>${data.name + ','} <em>${data.position + 'e Arrondissement'}</em></h4>
                <p>${data.address}</p>
                <p>Capacité d'accueil :${data.capacity}</p>
                <p class="description">${data.description}</p>
            `
            generateLogisticCalendar(popUpElement, data.id);

            popUp = popUpElement;

            let dashboardPopUp = document.createElement('div');
            dashboardPopUp.classList.add("dashboard-popup");

            dashboardPopUp.appendChild(popUp);

            dashboardLeft.insertBefore(dashboardPopUp, dashboardLeft.firstChild);
            dashboardLeft.addEventListener('click', shutPopup);
        })
        .catch(error => {
            console.error(error);
        });
}

function doSearch() {
    let prompt = search.value;
    searchInfos(prompt)
        .then(data => {
            if (searchContainer.childElementCount > 1) {
                searchContainer.lastChild.remove();
            }

            let searchResults = document.createElement("div");
            searchResults.classList.add("search-results");

            data.forEach(result => {
                let searchResult = document.createElement("div");
                searchResult.classList.add("card");
                searchResult.innerHTML = `
                    <div class="card-content">
                        <h4>${result.first_name} ${result.last_name.toUpperCase()}</h4>
                        <p><em>${result.mail}</em></p> 
                    </div>
                    <div class="card-tag">
                        <form method="POST" action="php-scripts/update_team.php">
                            <input type="hidden" name="member_id" value="${result.user_id}">
                            <label>Équipe
                                <input class="tiny-input" type="number" min="1" name="team_id" class="result-input" value="${result.team_id}">
                            </label>
                            <input class="form-submit" type="submit" value="Enregistrer" class="form-input">
                        </form>
                    </div>
                `;
                searchResults.appendChild(searchResult)
            });

            searchContainer.appendChild(searchResults);
        })
        .catch(error => {
            console.error(error);
        });
}

const dashboardLeft = document.querySelector(".dashboard-left");
const dashboardRight = document.querySelector(".dashboard-right");
let popUp;
const search = document.querySelector("#searchInput");
const searchContainer = search.parentNode;