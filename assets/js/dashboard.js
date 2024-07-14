document.addEventListener('DOMContentLoaded', (event) => {
    console.log('JavaScript is connected and working!');
    
    // Aquí puedes agregar más código para manipular el DOM o realizar otras acciones.
});

function updateCategories() {
    const container = document.getElementById('categories-container');
    const numberOfCategories = document.getElementById('modalidades').value;
    
    // Limpiar las categorías existentes
    container.innerHTML = '';
    
    for (let i = 1; i <= numberOfCategories; i++) {
        const categoryField = document.createElement('div');
        categoryField.classList.add('category-field');
        
        const label = document.createElement('label');
        label.setAttribute('for', `categoria${i}`);
        label.textContent = `Categoría ${i}:`;
        
        const select = document.createElement('select');
        select.setAttribute('id', `categoria${i}`);
        select.setAttribute('name', `categoria${i}`);
        select.setAttribute('required', true);
        
        const options = ['handball', 'futsal', 'futbol', 'basket', 'volley'];
        options.forEach(optionValue => {
            const option = document.createElement('option');
            option.setAttribute('value', optionValue);
            option.textContent = optionValue.charAt(0).toUpperCase() + optionValue.slice(1);
            select.appendChild(option);
        });
        
        categoryField.appendChild(label);
        categoryField.appendChild(select);
        container.appendChild(categoryField);
    }
}
