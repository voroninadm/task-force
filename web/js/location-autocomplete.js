const form = document.querySelector('#CreateTaskForm');

const cityInput = form.querySelector('#city');
const addressInput = form.querySelector('#address');
const latInput = form.querySelector('#lat');
const longInput = form.querySelector('#long');

if (form) {
    const autoCompleteJS = new autoComplete({
        selector: '#autoComplete',
        data: {
            'src': async (query) => {
                try {
                    // Fetch Data from Source - query to location/geocode ajax controller
                    const source = await fetch(`/location/geocode?geocode="${query}"`);
                    // Data should be an array of `Objects` or `Strings`
                    let data = await source.json();
                    return data;
                } catch (error) {
                    return error;
                }
            },
            // Data source 'Object' key to be searched
            'keys': ['location'],
        },

        // Responsible for the results list element rendering, interception, and customizing
        resultsList: {
            element: (list, data) => {
                if (!data.results.length) {
                    // Create "No Results" message element
                    const message = document.createElement("div");
                    // Add class to the created element
                    message.setAttribute("class", "no_result");
                    // Add message text content
                    message.innerHTML = `<span>Не найдено совпадений для "${data.query}"</span>`;
                    // Append message element to the results list
                    list.prepend(message);
                }
            },
            noResults: true,
        },

        // Responsible for the input field and results list events additions or overriding
        events: {
            input: {
                selection: (event) => {
                    const selection = event.detail.selection.value;
                    autoCompleteJS.input.value = selection.location;

                    cityInput.value = selection.city;
                    addressInput.value = selection.address;
                    longInput.value = selection.long;
                    latInput.value = selection.lat;
                },
                change: (event) => {
                    if (autoCompleteJS.input.value === '') {
                        cityInput.value = '';
                        latInput.value = '';
                        longInput.value = '';
                        addressInput.value = '';
                    }
                },
            },
        },

        searchEngine: 'loose',
        debounce: 300, // Milliseconds value
    });
}