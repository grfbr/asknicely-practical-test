<template>
  <div
    v-if="employees.length > 0"
    class="border border-white rounded p-3 m-3 bg-white bg-opacity-10"
    style="--bs-border-opacity: 0.2"
  >
    <h2 class="text-light p-0">Employee List</h2>
    <p class="text-white-50 fs-6 fw-light">
      You can update an individual's email using the provided input field.
      Please note, each email must be unique within the system
    </p>
    <table class="table table-bordered">
      <thead>
          <tr>
              <th>Employee Name</th>
              <th>Company Name</th>
              <th>Salary</th>
              <th>Email Address</th>
          </tr>
      </thead>
      <tbody>
          <tr v-for="employee in employees" :key="employee.id">
              <td>{{ employee.employee_name }}</td>
              <td>{{ employee.company_name }}</td>
              <td>${{ formatPrice(employee.salary) }}</td>
              <td>
                  <input
                      class="form-control"
                      type="text"
                      v-model="employee.email_address"
                      @blur="updateEmail(employee.id, employee.email_address)"
                  />
              </td>
          </tr>
      </tbody>
  </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      employees: [],
    };
  },
  async mounted() {
    this.fetchEmployees();
  },
  methods: {
    async fetchEmployees() {
      try {
        const response = await fetch(`${this.DOMAIN}/employees`);

        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(
            errorData.message ||
              "An error occurred while retrieving the employees."
          );
        }

        this.employees = await response.json();

        this.employees.forEach((employee) => {
          employee.originalEmail = employee.email_address;
        });
      } catch (error) {
        this.$notify({ type: "error", text: error.message });
      }
    },

    async updateEmail(id, email) {
      const employee = this.employees.find((emp) => emp.id === id);

      if (employee && employee.originalEmail !== email) {
        try {
          const response = await fetch(`${this.DOMAIN}/edit-email`, {
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ id, email }),
          });

          if (!response.ok) {
            const errorData = await response.json();
            throw new Error(
              errorData.message || "Failed to update email address."
            );
          }

          employee.originalEmail = email;

          this.$notify({
            type: "success",
            text: "Email address successfully updated.",
          });
        } catch (error) {
          employee.email_address = employee.originalEmail;
          this.$notify({ type: "error", text: error.message });
        }
      }
    },

    formatPrice(value) {
      let val = (value / 1).toFixed(2).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
  },
};
</script>
