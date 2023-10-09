
## AskNicely Practical Test

This is a simple employee management system built using PHP, MySQL, Vue3, and Docker.

### Prerequisites

Ensure you have the following installed on your machine:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Building and Running the Application

1. Clone this repository:
   ```bash
   git clone https://github.com/grfbr/asknicely-practical-test asknicely-practical-test
   ```

2. Navigate to the project directory:
   ```bash
   cd asknicely-practical-test
   ```

3. Navigate to the docker directory:
   ```bash
   cd docker
   ```

4. Build the Vue image:
   ```bash
   docker-compose build --no-cache
   ```

5. Start the services:
   ```bash
   docker-compose up
   ```

   This command will pull the necessary images, build the Docker containers, and start the services. The app should be accessible at `http://localhost:8000` and the Vue frontend at `http://localhost:8080`.

### Available Endpoints

1. **Upload CSV File**:
   - **URL**: `/import-csv`
   - **Data**: `csvFile`
   - **Method**: `POST`
   - **Description**: Uploads a CSV file to populate the employee data.

2. **List All Employees**:
   - **URL**: `/employees`
   - **Method**: `GET`
   - **Description**: Retrieves a list of all employees.

3. **Edit Employee Email Address**:
   - **URL**: `/edit-email`
   - **Data**: `email_address` `id`
   - **Method**: `PUT`
   - **Description**: Updates the email address of a specified employee.

4. **Average Salary by Company**:
   - **URL**: `/average-salary`
   - **Method**: `GET`
   - **Description**: Retrieves the average salary for each company.

---

### Future Improvements

- **Use a Framework**: Refactor with a PHP framework for better maintainability.
- **Auth Systems**: Add user authentication for secure access.
- **Pagination**: Handle large employee lists efficiently.
- **Sorting**: Allow sorting in the employee list by various criteria.
- **Error Handling**: Improve error feedback and logging.
- **Testing**: Increase test coverage.
- **Database**: Split company in a separeted table and optimize with necessary indexes.
- **Validation**: Enhance data validation on client and server sides.