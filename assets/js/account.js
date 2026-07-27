const typeWorks = document.querySelector('.input--type_works--contract');
const typeWorksList = document.querySelector('.typeWorksList');
const typeWorksListUnit = document.querySelectorAll('.typeWorksListUnit');

const executor = document.querySelector('.input--executor');
const executorList = document.querySelector('.executorList');
const executorListContent = document.querySelector('.executorListContent');
const executorListContainer = document.querySelector('.executorList--container');

const selectedWorkHidden = document.getElementById('selected_work_id');
const selectedExecutorHidden = document.getElementById('selected_executor_id');

document.addEventListener('mouseup',function(e){
        if (!typeWorks.contains(e.target)) {
            typeWorksList.classList.remove('typeWorksList--show');
        }
        else{
            typeWorksList.classList.add('typeWorksList--show');
        }
})

for (let i = 0; i < typeWorksListUnit.length; i++) {
        typeWorksListUnit[i].addEventListener('click',function(){
            typeWorks.value = this.textContent;
            selectedWorkHidden.value = this.dataset.typework;

            selectedExecutorHidden.value = '';
            
            $.ajax({
                url: '../php/account.php', //url серверного обработчика
                type: 'POST', // тип запроса
                dataType: 'json', 
                data: {typeWorkCategory: this.dataset.typework},
                success: (e)=>{
                    console.log(e);

                    // executorListContent.innerHTML = '';

                    if (e != null) {

                        e.forEach(executor => {
                        
                        // Формируем HTML-структуру для одного исполнителя
                        // response.name автоматически расшифрует кодировку вроде \u0421\u041f\u041a
                        const executorHTML = `
                            <p class="executorListUnit" data-executor="${executor.id}">${executor.name}</p>`;
                        
                        // Добавляем созданную карточку в конец контейнера
                        executorListContent.insertAdjacentHTML('beforeend', executorHTML);

                        
                    });

                    let executorListUnit = document.querySelectorAll('.executorListUnit');

                    document.addEventListener('mouseup',function(e){
                        if (!executor.contains(e.target)) {
                            executorList.classList.remove('executorList--show');
                        }
                        else{
                            executorList.classList.add('executorList--show');
                        }
                    })

                    for (let i = 0; i < executorListUnit.length; i++) {

                        executorListUnit[i].addEventListener('click', function(){
                            executor.value = this.textContent;
                            selectedExecutorHidden.value = this.dataset.executor;
                        })

                    }

                    } else {
                    // Если исполнителей в этой категории нет
                    executorListContent.innerHTML = '<p class="executorListUnit">В этой категории пока нет исполнителей.</p>';
                    }

                },
                error: function(xhr, status, error) {
                    console.error('Ошибка AJAX при загрузке:', error);
                }
            });
        })
}