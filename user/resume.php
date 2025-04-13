<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Resume Builder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</head>
<body class="bg-light">
  <div class="container my-5">
    <h2 class="text-center mb-4">Resume Builder</h2>
    <form id="resumeForm">
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="name" class="form-label">Full Name</label>
          <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label for="email" class="form-label">Email</label>
          <input type="email" id="email" name="email" class="form-control" required>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="phone" class="form-label">Phone</label>
          <input type="text" id="phone" name="phone" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label for="address" class="form-label">Address</label>
          <input type="text" id="address" name="address" class="form-control">
        </div>
      </div>
      <div class="mb-3">
        <label for="internship" class="form-label">Internship Experience</label>
        <textarea class="form-control" id="internship" name="internship" rows="3"></textarea>
      </div>
      <div class="mb-3">
        <label for="projects" class="form-label">Projects</label>
        <textarea class="form-control" id="projects" name="projects" rows="3"></textarea>
      </div>
      <div class="mb-3">
        <label for="activities" class="form-label">Extracurricular Activities</label>
        <textarea class="form-control" id="activities" name="activities" rows="3"></textarea>
      </div>
      <div class="mb-3">
        <label for="skills" class="form-label">Skills</label>
        <textarea class="form-control" id="skills" name="skills" rows="3"></textarea>
      </div>
      <div class="mb-3">
        <label for="education" class="form-label">Education</label>
        <textarea class="form-control" id="education" name="education" rows="3"></textarea>
      </div>
      <div class="text-center">
        <button type="button" class="btn btn-primary me-2" onclick="downloadPDF()">Download PDF</button>
        <button type="submit" class="btn btn-success">Save to Database</button>
      </div>
    </form>
  </div>

  <script>
    function downloadPDF() {
      const form = document.getElementById("resumeForm");
      const pdfOptions = {
        filename: 'Resume.pdf',
        margin: 0.5,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
      };
      html2pdf().from(form).set(pdfOptions).save();
    }

    document.getElementById("resumeForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const formData = new FormData(this);
      fetch("save_resume.php", {
        method: "POST",
        body: formData
      })
      .then(res => res.text())
      .then(data => alert(data))
      .catch(err => alert("Error saving resume!"));
    });
  </script>
</body>
</html>
