import axios from './libs/axios.js';
import serializeForm from './helpers/serializeForm.js';
import { confirmAlert, errorAlert, successAlert } from "./libs/sweetAlert2.js";
import { strReplace, ucWords } from './helpers/formatter.js';
import { employee_formfield, visitor_formfield } from './misc/form.fields.js';
import { loader, loader2 } from './misc/loaders.js';

// VARIABLES
const [div_container, select_button, log_book_form] = ['div_container', 'select_button', 'log_book_form'].map(e => document.getElementById(e));
const [employee, visitor] = ['employee', 'visitor'].map(e => document.getElementById(e));
let visitor_type = '';

// EVENT LISTENERS
employee.addEventListener('click', () => {
    visitor_type = 'Employee';
    select_button.style.display = 'none';
    log_book_form.style.display = 'block';
    div_container.classList.add('margin-top-form');
    div_container.classList.add('overlay');
    div_container.classList.remove('container');
    log_book_form.innerHTML = employee_formfield;
    fetchDivisionOptions();
});

visitor.addEventListener('click', () => {
    visitor_type = 'Visitor';
    select_button.style.display = 'none';
    log_book_form.style.display = 'block';
    div_container.classList.add('margin-top-form');
    div_container.classList.add('overlay');
    div_container.classList.remove('container');
    log_book_form.innerHTML = visitor_formfield;
    fetchDivisionOptions();
});

document.addEventListener('click', (e) => {
    const targetElement = e.target;
    const isSvgOrPath = targetElement.id === 'back' || targetElement.closest('#back');
    if (isSvgOrPath) {
        const log_form = document.getElementById('log_form');
        log_form.reset();
        log_book_form.style.display = 'none';
        select_button.style.display = 'flex';
        div_container.classList.remove('margin-top-form');
        div_container.classList.remove('overlay');
    }
});
document.addEventListener('submit', (e) => {
    e.preventDefault();
    const form_id = e.target.id;
    if (form_id == 'log_form') {
        const payload = serializeForm(e.target);
        payload.type = visitor_type;
        const question = "Please confirm that all the details you provided are accurate. Do you want to proceed?";
        confirmAlert(question, handleFormSubmit, payload);
    }
});

document.addEventListener('change', (e) => {
    const id = e.target.id.trim();
    const purpose = document.getElementById('purpose');
    if (id == 'office') {
        const office = e.target.value;
        if (visitor_type == 'Visitor') {
            purpose.value = `Visit the ${ucWords(strReplace(office))}`;
        }
    } else if (id == 'employee_id') {
        const employee_id = e.target.value;
        getEmployeeInfo(employee_id, purpose);
    }
});

// FUNCTIONS
const getEmployeeInfo = async (id, purpose) => {
    const employeeInfoContainer = document.getElementById('employeeInfoContainer');
    const errorEmployeeId = document.getElementById('errorEmployeeId');
    employeeInfoContainer.style.display = 'none';
    errorEmployeeId.innerHTML = loader2;
    purpose.value = 'Work';
    try {
        const { data } = await axios.get('../api/findEmployee.php', { params: { id: id } });
        employeeInfoContainer.style.display = 'block';
        errorEmployeeId.textContent = '';
        displayEmployeeInfo(employeeInfoContainer, data);
        purpose.value = `Work at the ${ucWords(data.office)}`;
    } catch (error) {
        const { response } = error;
        employeeInfoContainer.style.display = 'none';
        errorEmployeeId.textContent = response.data.message;
    }
}

const displayEmployeeInfo = (employeeInfoContainer, data) => {
    employeeInfoContainer.innerHTML = `
        <div class="form-group">
            <div style="display: flex; flex-wrap: wrap;">
                <div style="flex: 1; margin-right: 10px;">
                    <label for="fname">First Name</label>
                    <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="${ucWords(data.fname)}" readonly>
                    <div class="form-text text-danger" id="errorFName"></div>
                </div>
                <div style="flex: 1;">
                    <label for="lname">Last Name</label>
                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="${ucWords(data.lname)}" readonly>
                    <div class="form-text text-danger" id="errorLName"></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Office</label>
            <input type="text" class="form-control" name="office" id="office" placeholder="Employee Office" value="${ucWords(data.office)}" readonly>
            <div class="form-text text-danger" id="errorOffice"></div>
        </div>
    `;
    
}

const fetchDivisionOptions = async () => {
    const division = document.getElementById('division');
    try {
        const { data } = await axios.get('../api/divisionEnums.php');
        const options = ['<option disabled selected hidden>SELECT DIVISION</option>']
            .concat(data.map(opt => `<option value="${opt}">${opt}</option>`))
            .join('');
        division.innerHTML = options;
    } catch (error) {
        console.error(error);
    }
}

const handleFormSubmit = async (payload) => {
    const log_form = document.getElementById('log_form');
    const button = log_form.getElementsByTagName('button')[0];

    const [errorOffice, errorEmployeeId, errorFName, errorLName, errorDivision, errorPurpose] = ['errorOffice', 'errorEmployeeId', 'errorFName', 'errorLName', 'errorDivision', 'errorPurpose'].map(e => document.getElementById(e));
    
    button.disabled = true;
    button.innerHTML = loader;

    try {
        const { data } = await axios.post('../api/logVisitor.php', payload);
        div_container.classList.remove('overlay');
        successAlert(data.message);
        log_form.reset();
        log_book_form.style.display = 'none';
        select_button.style.display = 'flex';
        [errorOffice, errorEmployeeId, errorFName, errorLName, errorDivision, errorPurpose].forEach(e => { if (e) e.textContent = '' });
        
    } catch (error) {
        const { response } = error;
        div_container.classList.add('overlay');
        
        if (response && response.status == 422) {
            const errorMessages = response.data.message;
            if (visitor_type == 'Employee') {
                errorEmployeeId.textContent = errorMessages.employee_id;
                if (errorFName && errorLName && errorOffice) {
                    errorFName.textContent = errorMessages.fname;
                    errorLName.textContent = errorMessages.lname;
                    errorOffice.textContent = errorMessages.office;
                }
            } else if (visitor_type == 'Visitor') {
                errorFName.textContent = errorMessages.fname;
                errorLName.textContent = errorMessages.lname;
                errorOffice.textContent = errorMessages.office;
            }
            errorPurpose.textContent = errorMessages.purpose;
            errorDivision.textContent = errorMessages.division;
            if (errorMessages.divisionRefetch && errorMessages.divisionRefetch == true) {
                fetchDivisionOptions();
            }
        } else if (response && response.status == 400) {
            errorAlert(response.data.message);
        } else {
            errorAlert(response.data.message);
        }

    } finally {
        button.disabled = false;
        button.innerHTML = 'Submit Now';    
    }
}
