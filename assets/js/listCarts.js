const modal = document.getElementById('AddModal');
const openBtn = document.getElementById('openModalBtn');
const idInput = document.getElementById('edit_id');
const categoryInput = document.querySelector('.input--category');
const subcategoryInput = document.querySelector('.input--subcategory');
const descriptionInput = document.querySelector('.input--description');
const deleteBtn = document.querySelector('.delete-btn');
const enterInput = document.querySelector('.input--enter');
const optionsList = document.querySelector('#options-list');
const categoryHidden = document.querySelector('#category_id');
const subcategoryHidden = document.querySelector('#subcategory_id');

let editBtn = document.querySelectorAll('.cart--unit');

// Функция безопасной динамической привязки datalist к инпуту подкатегорий
function updateSubcategoryList(categoryId) {
    const listId = `${categoryId}`;
    
    // Хак для браузеров: полностью удаляем атрибут и возвращаем, чтобы обновить кэш подсказок
    subcategoryInput.removeAttribute('list'); 
    
    if (categoryId) {
        // Устанавливаем строковый ID (например, "3")
        subcategoryInput.setAttribute('list', listId); 
    }
}

// Открытие на добавление нового элемента
openBtn.addEventListener('click', () => {
    modal.children[0].children[0].innerHTML = 'Добавить карточку';
    idInput.value = '';
    categoryInput.value = '';
    subcategoryInput.value = '';
    descriptionInput.value = '';
    categoryHidden.value = '';     
    subcategoryHidden.value = '';  
    updateSubcategoryList(null); // Очищаем список подкатегорий
    enterInput.value = 'Добавить';
    deleteBtn.classList.add('hidden-btn');
    modal.showModal();
});

// Редактирование существующей карточки
for (let i = 0; i < editBtn.length; i++) {
    editBtn[i].addEventListener('click', () => {
        modal.children[0].children[0].innerHTML = 'Редактировать карточку';
        enterInput.value = 'Сохранить';
        deleteBtn.classList.remove('hidden-btn');

        modal.showModal();

        $.ajax({
            url: '../php/list-carts.php',
            type: 'POST',
            data: { idCart: editBtn[i].dataset.cart },
            dataType: 'json',
            success: function(response) {
                idInput.value = response.id;
                categoryInput.value = response.category;
                descriptionInput.value = response.description;
                
                // Ищем ID выбранной категории в datalist
                const categoryOption = optionsList.querySelector(`option[value="${response.category}"]`);
                if (categoryOption) {
                    const catId = categoryOption.getAttribute('data-id');
                    categoryHidden.value = catId;
                    
                    // Обновляем привязку списка подкатегорий через общую функцию
                    updateSubcategoryList(catId);
                    
                    // Записываем текст подкатегории только ПОСЛЕ обновления списка
                    subcategoryInput.value = response.subcategory.name;
                    
                    // Ищем ID подкатегории в подключенном списке
                    const subDatalist = document.getElementById(`${catId}`);
                    
                    if (subDatalist) {
                        const subOption = subDatalist.querySelector(`option[value="${response.subcategory.name}"]`);
                        if (subOption) {
                            subcategoryHidden.value = subOption.getAttribute('data-id');
                        }
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Ошибка AJAX при загрузке:', error);
            }
        });
    });
}

// Удаление карточки
deleteBtn.addEventListener('click', () => {
    if (confirm('Вы уверены, что хотите удалить данную карточку?')) {
        $.ajax({
            url: '../php/list-carts.php',
            type: 'POST',
            data: { deleteIdCart: idInput.value },
            success: function(responseDelete) {
                if (responseDelete == 'true' || responseDelete === true) {
                    location.reload();
                }          
            },
            error: function(xhr, status, error) {
                console.error('Ошибка AJAX при удалении:', error);
            }
        });
    }
});

// Закрытие окна при клике на оверлей
modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.close();
    }
});

// Изменение главной категории вручную
categoryInput.addEventListener('input', function() {
    const selectedValue = this.value;
    const selectedOption = optionsList.querySelector(`option[value="${selectedValue}"]`);

    if (selectedOption) {
        const categoryId = selectedOption.getAttribute('data-id');
        
        categoryHidden.value = categoryId;
        
        // Меняем список подкатегорий через функцию-хак
        updateSubcategoryList(categoryId);
        
        // Сбрасываем старые текстовые значения подкатегории, так как категория новая
        subcategoryInput.value = '';
        subcategoryHidden.value = '';
    } else {
        categoryHidden.value = '';
        updateSubcategoryList(null);
        subcategoryInput.value = '';
        subcategoryHidden.value = '';
    }
});

// Изменение подкатегории вручную
subcategoryInput.addEventListener('input', function() {
    const selectedValue = this.value;
    const currentListId = this.getAttribute('list');
    
    if (currentListId) {
        const subDatalist = document.getElementById(currentListId);
        if (subDatalist) {
            const selectedOption = subDatalist.querySelector(`option[value="${selectedValue}"]`);
            if (selectedOption) {
                subcategoryHidden.value = selectedOption.getAttribute('data-id');
            } else {
                subcategoryHidden.value = '';
            }
        }
    }
});