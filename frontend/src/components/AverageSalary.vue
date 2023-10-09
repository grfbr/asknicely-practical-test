<template >
  <div
    v-if="companies.length > 0"
    class="border border-white rounded p-3 m-3 bg-white bg-opacity-10"
    style="--bs-border-opacity: 0.2"
  >
    <h2 class="text-light p-0">Average Salary by Company</h2>
    <ul class="list-group mt-3">
      <li
        class="list-group-item"
        v-for="company in companies"
        :key="company.companyName"
      >
        <strong>{{ company.company_name }}:</strong> ${{
          formatPrice(company.average_salary)
        }}
      </li>
    </ul>
  </div>
</template>


<script>
export default {
  data() {
    return {
      companies: [],
    };
  },
  async mounted() {
    this.fetchAverageSalary();
  },
  methods: {
    formatPrice(value) {
      let val = (value / 1).toFixed(2).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },

    async fetchAverageSalary() {
      try {
        const response = await fetch(`${this.DOMAIN}/average-salary`);

        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(
            errorData.message ||
              "There was an issue fetching the average salaries."
          );
        }

        this.companies = await response.json();
      } catch (error) {
        this.$notify({ type: "error", text: error.message });
      }
    },
  },
};
</script>
