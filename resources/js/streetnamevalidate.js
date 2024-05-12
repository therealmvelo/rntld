const searchInput = document.getElementById('txtStreetName');
const suggestionsList = document.getElementById('suggestions');
let addedStreetNames = [];
let map; // Declaring map outside any function

searchInput.addEventListener('input', () => {
  const searchTerm = searchInput.value;
  if (searchTerm.trim() !== '') {
    getSuggestions(searchTerm);
  } else {
    clearSuggestions();
  }
});

function getSuggestions(query) {
  const apiUrl = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json`;

  fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
      displayStreetNameSuggestions(data, query);
    })
    .catch(error => console.error('Error:', error));
}

function displayStreetNameSuggestions(suggestions, query) {
  clearSuggestions();

  suggestions.forEach(result => {
    let streetName = result.address?.road || result.address?.pedestrian || result.name || 'Unknown Street';

    if (!addedStreetNames.includes(streetName)) {
      addedStreetNames.push(streetName);

      const suggestionItem = document.createElement('li');
      suggestionItem.className = 'suggestion';
      
      // Highlight matching text in bold
      const index = streetName.toLowerCase().indexOf(query.toLowerCase());
      const boldedStreetName = index !== -1
        ? streetName.substr(0, index) + "<strong>" + streetName.substr(index, query.length) + "</strong>" + streetName.substr(index + query.length)
        : streetName;

      suggestionItem.innerHTML = boldedStreetName;
      suggestionItem.addEventListener('click', () => {
        searchInput.value = streetName;
        clearSuggestions();
        
        // Fetch and log coordinates when a street name is clicked
        const apiUrl = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(streetName)}&format=json`;

        fetch(apiUrl)
          .then(response => response.json())
          .then(data => {
            if (data.length > 0) {
              const firstResult = data[0];
              const lt = parseFloat(firstResult.lat);
              const ln = parseFloat(firstResult.lon);
              console.log('Street Coordinates:', lt, ln);
              console.log('Found address:', firstResult.display_name);
              // Check if map is not initialized yet
              if (!map) {
                map = L.map('map').setView([lt, ln], 13);

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                  maxZoom: 19,
                  attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
              }
            } else {
              console.log('Coordinates not found for', streetName);
            }
          })
          .catch(error => console.error('Error:', error));
      });
      suggestionsList.appendChild(suggestionItem);
    }
  });

  // Show the suggestions container
  suggestionsList.style.display = 'block';
}

function clearSuggestions() {
  // Hide and clear the suggestions container
  suggestionsList.style.display = 'none';
  suggestionsList.innerHTML = '';
  addedStreetNames = [];
}
