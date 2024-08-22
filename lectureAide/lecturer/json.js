fetch('test.php')  // Replace with the URL of your PHP script
  .then(response => response.json())
  .then(data => {
    // Format the JSON data for display
    const formattedJson = JSON.stringify(data, null, 2);  // Indent for readability

    // Update the content of the div element
    document.getElementById("json-data").textContent = formattedJson;
  })
  .catch(error => console.error(error));
