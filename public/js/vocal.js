
    /**
     *
     */
    function changeLanguage(languageCode)
    {
        let url = "/changeLanguage";
        ajaxCall(url,
            JSON.stringify({'languageCode': languageCode})
        );
    }

    /**
     * Post request to server side
     *
     * @param url
     * @param data
     */
    function ajaxCall(url, data) {

        $.ajax({
            type: 'post',
            url: url,
            data: data,
            contentType: 'application/json',
            cache: false,
            processData: false
        }).success(function (response) {
            // Successful update
            // Reload the national flag
            $("#nationalFlag").attr("src", response.flag);
            // Reload the index page to implement the change of nationality
            location.replace('/verb');

        }).fail(function (jqXHR, textStatus, errorThrown) {

            alert("Error on Ajax call");
            alert(errorThrown);

            return false;
        });
    }
