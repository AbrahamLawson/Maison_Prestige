function logisticDateList(housingId) {
    return new Promise((resolve, reject) => {
        const xmlhttp = new XMLHttpRequest();
        let justeAvoirUnTrucIterable = housingId.toString() 
        let extension = justeAvoirUnTrucIterable.match(/\D+/g)
        const iD = justeAvoirUnTrucIterable.match(/\d+/g)[0]
         
        // En fait le problème est que j'ai besoin du calendrier dans deux dossiers différents, je dois donc gérer les chemins ou soit refaire un par dossier
        // J'ai passé le chemin en parametre avec l'id et arrivé au point d'utilisation, je sépare les deux colis 😁.
        // Pas de problème avec l'autre dossier car de son coté, le second colis n'est pas filé, après départage, il est un null 🙂.

        extension = extension===null? "" : extension
        xmlhttp.open("GET", "."+extension+"/php-scripts/logistic-availability.php?id=" + iD, true);
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

// Fonction pour générer le calendrier
function generateCalendar(year, month, data) {
    calendarDiv.innerHTML = '';

    let date = new Date(year, month);
    let daysInMonth = new Date(year, month + 1, 0).getDate();
    let firstDayIndex = date.getDay();

    let monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

    let header = document.createElement('h3');
    header.innerHTML = monthNames[month] + ' ' + year;
    calendarDiv.appendChild(header);

    let table = document.createElement('table');

    // Créer la ligne des jours de la semaine
    let daysOfWeek = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
    let headerRow = document.createElement('tr');
    for (let i = 0; i < daysOfWeek.length; i++) {
        let th = document.createElement('th');
        th.innerHTML = daysOfWeek[i];
        headerRow.appendChild(th);
    }
    table.appendChild(headerRow);

    // Remplir les jours du mois
    let currentDay = 1;
    for (let i = 0; i < 6; i++) {
        let row = document.createElement('tr');
        for (let j = 0; j < 7; j++) {
            if (i === 0 && j < firstDayIndex) {
                let cell = document.createElement('td');
                row.appendChild(cell);
            } else if (currentDay > daysInMonth) {
                break;
            } else {
                let cell = document.createElement('td');
                cell.innerHTML = currentDay;
                
                year = String(currentYear);
                month = String(currentMonth + 1);
                day = String(currentDay);
                if (month.length < 2) {
                    month = "0" + month;
                }
                if (day.length < 2) {
                    day = "0" + day;
                }
                if (data.includes(year+'-'+month+'-'+day))
                {
                    cell.classList.add("not-available");
                }
                else
                {
                    cell.classList.add("available");
                }
                row.appendChild(cell);
                currentDay++;
            }
        }
        table.appendChild(row);
    }

    calendarDiv.appendChild(table);
}

// Fonction pour afficher le mois précédent
function showPreviousMonth() {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    generateCalendar(currentYear, currentMonth, data);
}

// Fonction pour afficher le mois suivant
function showNextMonth() {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    generateCalendar(currentYear, currentMonth, data);
}

function generateLogisticCalendar(containerElement, housingId)
{
    let container = document.createElement('div');
    container.id = 'calendar-container';
    containerElement.appendChild(container);
    calendarContainer = container;
    calendarDiv = document.createElement('div');
    calendarDiv.id = 'calendar';
    calendarContainer.appendChild(calendarDiv);

    logisticDateList(housingId).then(responseData => {
        data = responseData;

        // Appeler la fonction pour générer le calendrier avec l'année et le mois actuels
        let currentDate = new Date();
        currentYear = currentDate.getFullYear();
        currentMonth = currentDate.getMonth();
        generateCalendar(currentYear, currentMonth, data);

        let buttonsContainer = document.createElement('div');
        buttonsContainer.classList.add('buttons-container');

        // Ajouter des boutons "Précédent" et "Suivant" pour naviguer entre les mois
        let previousButton = document.createElement('button');
        previousButton.innerHTML = 'Précédent';
        previousButton.addEventListener('click', showPreviousMonth);
        buttonsContainer.appendChild(previousButton);

        let nextButton = document.createElement('button');
        nextButton.innerHTML = 'Suivant';
        nextButton.addEventListener('click', showNextMonth);
        buttonsContainer.appendChild(nextButton);
        calendarContainer.insertBefore(buttonsContainer, calendarDiv);

    })
    .catch(error => {
        console.error(error);
    })
}

let calendarContainer;
let calendarDiv;
let currentYear;
let currentMonth;
let data;