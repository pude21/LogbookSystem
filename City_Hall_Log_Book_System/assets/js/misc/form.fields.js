export const employee_formfield = `
    <div style="display: flex; justify-content: space-between; align-items: center">
        <h3><i class="fas fa-arrow-left ch-green-text" id="back"></i></h3>
        <h3 style="font-weight: bold" class="ch-green-text">EMPLOYEE LOG FORM</h3>
    </div>
    <form id="log_form">
        <div class="form-group">
            <label for="employee_id">Employee ID</label>
            <input class="form-control" id="employee_id" name="employee_id" placeholder="Select Employee ID">
            <div class="form-text text-danger" id="errorEmployeeId"></div>
        </div>
        <div id="employeeInfoContainer"></div>

        <div class="form-group">
            <label for="division">Division</label>
            <select class="form-control" id="division" name="division"></select>
            <div class="form-text text-danger" id="errorDivision"></div>
        </div>

        <div class="form-group">
            <label for="purpose">Purpose</label>
            <textarea class="form-control" id="purpose" name="purpose" placeholder="Enter your purpose here..."
                rows="4">Work</textarea>
            <div class="form-text text-danger" id="errorPurpose"></div>
        </div>

        <div class="form-group" style="display: flex; justify-content: flex-end;">
            <button type="submit" name="submit" class="btn ch-green text-white btn-submit">Submit Now</button>
        </div>
    </form>
`;
export const visitor_formfield = `
    <div style="display: flex; justify-content: space-between; align-items: center">
        <h3><i class="fas fa-arrow-left ch-green-text" id="back"></i></h3>
        <h3 style="font-weight: bold" class="ch-green-text">VISITOR LOG FORM</h3>
    </div>
    <form id="log_form">
        <div class="form-group">
            <div style="display: flex; flex-wrap: wrap;">
                <div style="flex: 1; margin-right: 10px;">
                    <label for="fname">First Name</label>
                    <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name">
                    <div class="form-text text-danger" id="errorFName"></div>
                </div>
                <div style="flex: 1;">
                    <label for="lname">Last Name</label>
                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name">
                    <div class="form-text text-danger" id="errorLName"></div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="office">Office</label>
            <input type="text" class="form-control" id="office" name="office" placeholder="Input Office">
            <div class="form-text text-danger" id="errorOffice"></div>
        </div>

        <div class="form-group">
            <label for="division">Division</label>
            <select class="form-control" id="division" name="division"></select>
            <div class="form-text text-danger" id="errorDivision"></div>
        </div>

        <div class="form-group">
            <label for="purpose">Purpose</label>
            <textarea class="form-control" id="purpose" name="purpose" placeholder="Enter your purpose here..."
                rows="4">Visit</textarea>
            <div class="form-text text-danger" id="errorPurpose"></div>
        </div>

        <div class="form-group" style="display: flex; justify-content: flex-end;">
            <button type="submit" name="submit" class="btn ch-green text-white btn-submit">Submit Now</button>
        </div>
    </form>
`;