<template>
  <div
    class="border border-white rounded p-3 m-3 bg-white bg-opacity-10"
    style="--bs-border-opacity: 0.2"
  >
    <h2 class="text-light p-0">CSV Employee Importation</h2>
    <p class="text-white-50 fs-6 fw-light">
      Upload many employee details at once using a CSV file.<br />Ensure data is
      organized in columns like Company Name, Employee Name, Email Address,
      Salary.
    </p>
    <input
      class="form-control"
      type="file"
      ref="fileInput"
      accept=".csv,text/csv"
      @change="uploadCsv"
    />
  </div>
</template>


<script>
export default {
  methods: {
    async uploadCsv() {
      const file = this.$refs.fileInput.files[0];
      const formData = new FormData();
      formData.append("csvFile", file);

      try {
        const response = await fetch(`${this.DOMAIN}/import-csv`, {
          method: "POST",
          body: formData,
        });

        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.message || "Error uploading CSV.");
        }

        this.$emit("csv-uploaded");
        this.$notify({ type: "success", text: "CSV imported successfully!" });
        this.$refs.fileInput.value = "";
      } catch (error) {
        this.$notify({ type: "error", text: error.message });
      }
    },
  },
};
</script>
