<template>
  <div class="">
    <CsvUpload @csv-uploaded="refreshEmployeesAndAverageSalary" />
    <EmployeeList ref="employeeList" />
    <AverageSalary ref="averageSalary" />
    <notifications position="top center" />
  </div>
</template>

<script>
import CsvUpload from "@/components/CsvUpload.vue";
import EmployeeList from "@/components/EmployeeList.vue";
import AverageSalary from "@/components/AverageSalary.vue";

export default {
  components: {
    CsvUpload,
    EmployeeList,
    AverageSalary,
  },

  mounted() {
    document.title = "Ask Nicely | Pratical Test";
  },

  methods: {
    refreshEmployeesAndAverageSalary() {
      this.$refs.employeeList.fetchEmployees();
      this.$refs.averageSalary.fetchAverageSalary();
    },
  },
};
</script>
