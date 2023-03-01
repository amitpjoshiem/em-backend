import { Modal} from "bootstrap"
import moment from "moment";
window.axios = require('axios');
document.querySelectorAll('.confirm').forEach(function (e) {
    e.onclick = function () {
        return confirm('Are you sure?');
    }
});
const element = document.getElementById('advisors');
if (element !== null) {
    window.advisorChoices = new Choices(element, {
        removeItems: true,
        removeItemButton: true,
    });
}

let encode = document.getElementById('encode');
if (encode !== null) {
    encode.onclick = function () {
        let url = this.getAttribute('data-url');
        let id = document.getElementById('encode_input').value;
        axios.get(url, {
            params: {
                id: id
            }
        }).then(function (res) {
            document.getElementById('encode_result').value = res.data.hash;
        })
    };
}

let decode = document.getElementById('decode');
if (decode !== null) {
    document.getElementById('decode').onclick = function () {
        let url = this.getAttribute('data-url');
        let hashed = document.getElementById('decode_input').value;
        axios.get(url, {
            params: {
                hashed: hashed
            }
        }).then(function (res) {
            document.getElementById('decode_result').value = res.data.id;
        })
    };
}


let sfImportData = document.getElementById('salesforce_import');
if (sfImportData !== null) {
    // const centrifuge = new Centrifuge(sfImportData.getAttribute('data-url'));
    // const sub = centrifuge.subscribe('salesforce_import');
    // sub.subscribe();
    // centrifuge.connect();
}

let importObjectsRow = document.querySelectorAll('.import-row');
if (importObjectsRow.length !== 0) {
    document.querySelectorAll('.import-row').forEach(function (diffRow) {
        setDateTimes(diffRow)
        setInterval(function () {
            setDateTimes(diffRow)
        }, 1000);
    });
}

let importStatusTable = document.getElementById('import_status_table');
if (importStatusTable !== null) {
    setInterval(function () {
        let url = importStatusTable.getAttribute('data-url');
        axios.get(url).then(function (res) {
            res.data.data.forEach(function(data) {
                let row = document.querySelector('tr[data-object="' + data.object + '"]');
                row.setAttribute('data-timestamp', data.end_job * 1000);
            });
        });
    }, 30000);
}

let apiStatus = document.getElementById('salesforce_api_status');
if (apiStatus !== null) {
    getApiStatus(apiStatus);
    setInterval(function () {
        getApiStatus(apiStatus);
    }, 30000);
}

function getApiStatus(apiStatus)
{
    let url = apiStatus.getAttribute('data-url');
    axios.get(url).then(function (res) {
        console.log(res);
        let icon = apiStatus.querySelector('i');
        icon.classList.remove('text-danger', 'text-success', 'text-secondary');
        icon.classList.add(res.data.status ? 'text-success' : 'text-danger');
    });
}


function setDateTimes(diffRow)
{
    let timestamp = Number(diffRow.getAttribute('data-timestamp'));
    diffRow.querySelector('.import-time-local').innerHTML = moment(timestamp).format('Do MMMM YYYY, HH:mm:ss');
    diffRow.querySelector('.import-time-server').innerHTML = moment(timestamp).utc().format('Do MMMM YYYY, HH:mm:ss');
    let diff = diffRow.querySelector('.import-diff');
    diff.innerHTML = moment(timestamp).fromNow();
    let diffValue = moment().unix() * 1000 - timestamp;
    diffRow.classList.remove('text-warning', 'text-danger');
    diffRow.classList.add(diffValue > 5*60000 ? 'text-danger' : diffValue > 2*60000 ? 'text-warning' : 'bg-transparent');
}

let serverTime = document.getElementById('server_time');
if (serverTime !== null) {
    serverTime.innerHTML = 'Server Time: ' + moment().utc().format('Do MMMM YYYY, HH:mm:ss');
    setInterval(function () {
        serverTime.innerHTML = 'Server Time: ' + moment().utc().format('Do MMMM YYYY, HH:mm:ss');
    }, 1000);
}

const tryExceptions = document.getElementsByClassName('try-exception');
if (tryExceptions.length) {
    let tryStatusModalElem = document.getElementById('try_status');
    tryStatusModalElem.addEventListener('hidden.bs.modal', event => {
        window.location.reload();
    })
    Array.from(tryExceptions).forEach((el) => {
        el.onclick = function () {
            axios.post(el.getAttribute('data-href')).then(function (res) {
                tryStatusModalElem.querySelector('#try_status_label').innerHTML = '<i style="color: green" class="fa-solid fa-circle-check fa-2xl"></i> Success';
                tryStatusModalElem.querySelector('#try_status_text').innerHTML = 'Refresh Page after closing Modal';
                (new Modal(tryStatusModalElem)).show();
            }).catch(function () {
                tryStatusModalElem.querySelector('#try_status_label').innerHTML = '<i style="color: red" class="fa-solid fa-circle-exclamation fa-2xl"></i> Woops Error Again';
                tryStatusModalElem.querySelector('#try_status_text').innerHTML = 'Page will be refreshed after closing Modal';
                (new Modal(tryStatusModalElem)).show();
            });
        };
    });

}



