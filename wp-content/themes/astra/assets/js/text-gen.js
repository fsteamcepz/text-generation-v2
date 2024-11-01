jQuery(document).ready(function($)
{
    // генерація тексту
    var generateButton = $('#generateButton');
    var searchInput = $('#searchTerm');
    var resultContainer = $('#generationResult');
    
    // меню
    var addTermButton = $('#addTermButton');
    var addTermForm = $('#addTermForm');
    var submitButton = $('#submitTermButton');

    // дані для нового терміну
    var category = $('#category').val();
    var subcategory = $('#subcategory').val();
    var termNew = $('#term').val();
    var definition = $('#definition').val();

    generateButton.on('click', function(e)
    {
        e.preventDefault();

        // перевіряємо чи авторизований користувач
        if (!textGenAjax.is_logged_in)
        {
            resultContainer.html('Будь ласка, увійдіть або зареєструйтеся для використання генерації тексту!');
            return;
        }

        var term = searchInput.val();

        if (!term)
        {
            resultContainer.html('Будь ласка, введіть термін для пошуку!');
            return;
        }

        // показуємо індикатор завантаження
        resultContainer.html('Генеруємо текст...');
        
        $.ajax({
            url: textGenAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'generate_text',
                term: term,
                nonce: textGenAjax.nonce
            },
            success: function(response) {
                if (response.success)
                {
                    resultContainer.html(response.data);

                    searchInput.val(''); // очищаємо поле вводу
                }
                else
                {
                    resultContainer.html('Помилка: ' + (response.data || 'Невідома помилка'));
                }
            },
            error: function(xhr, status, error) {
                resultContainer.html('Помилка зєднання з сервером: ' + error);
            }
        });
    });

    addTermButton.on('click', function()
    {
        // видимість форми
        if (addTermForm.is(':visible'))
        {
            addTermForm.hide();
            addTermButton.text('+');
        }
        else
        {
            addTermForm.show();
            addTermButton.text('-');
            $('#category, #subcategory, #term, #definition').val(''); // очищаємо поля вводу
            $('#errorMessage').hide(); // ховаємо повідомлення помилки
        }
    });

    // додаємо термін
    submitButton.on('click', function (e)
    {
        e.preventDefault();
    
        // Перевірка чи авторизований користувач
        if (!textGenAjax.is_logged_in)
        {
            $('#errorMessage').text('Будь ласка, увійдіть або зареєструйтеся!').show();
            return;
        }

        // отримуємо значення
        var category = $('#category').val();
        var subcategory = $('#subcategory').val();
        var termNew = $('#term').val();
        var definition = $('#definition').val();
    
        if (!category || !termNew || !definition)
        {
            $('#errorMessage').text('Будь ласка, заповніть всі поля!').show();
            return;
        }
    
        // Перевірка наявності терміну в БД
        $.ajax({
            url: textGenAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'check_term_exists',
                category: category,
                subcategory: subcategory,
                term: termNew,
                nonce: textGenAjax.nonce // Додаємо nonce
            },
            success: function (response)
            {
                if (response.success)
                {
                    if (response.data.term_exists)
                    {
                        $('#errorMessage').text('Термін вже існує в базі даних!').show();
                        return;
                    }
    
                    // Якщо термін не існує, надсилаємо запит на його додавання
                    $.ajax({
                        url: textGenAjax.ajax_url,
                        type: 'POST',
                        data: {
                            action: 'add_new_term',
                            category: category,
                            subcategory: subcategory,
                            term: termNew,
                            definition: definition,
                            nonce: textGenAjax.nonce
                        },
                        success: function (response) {
                            if (response.success)
                            {
                                alert('Новий термін успішно додано!');
                                $('#category, #subcategory, #term, #definition').val('');
                                $('#errorMessage').hide();
                                addTermForm.hide();
                                addTermButton.text('+');
                            }
                            else
                            {
                                $('#errorMessage').text('Помилка додавання терміну: ' + (response.data || 'Невідома помилка')).show();
                            }
                        },
                        error: function (xhr, status, error) {
                            $('#errorMessage').text('Помилка зєднання з сервером: ' + error).show();
                        }
                    });
                }
                else
                {
                    $('#errorMessage').text('Помилка перевірки терміну: ' + (response.data || 'Невідома помилка')).show();
                }
            },
            error: function (xhr, status, error)
            {
                $('#errorMessage').text('Помилка зєднання з сервером: ' + error).show();
            }
        });
    });    
});