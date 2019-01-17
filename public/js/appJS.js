var $collectionHolder;

// setup an "add a tag" link
var $addTagButton = $('<button class="add_tag_link btn btn-primary mb-4">Ajouter un épisode</button>');
var $newLinkLi = $('<div class="col md-2"></div>').append($addTagButton);

jQuery(document).ready(function () {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('div.tags');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $('#anime_episodes___name___titre').prop('required',false);
    $('#anime_episodes___name___numero').prop('required',false);
    $('#anime_episodes___name___lien').prop('required',false);
    
    

    $addTagButton.on('click', function (e) {
        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);
    });
});

function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');
    

    // get the new index
    var index = $collectionHolder.data('index');

    

    var newForm = prototype;
    
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<div class="col md-2"></div>').append(newForm);
    $newLinkLi.before($newFormLi);
}

jQuery(document).ready(function () {
    $displayButton = $('div.add-episode-button');

    $displayButton.on('click', function (e) {

        // Display add-form
        $('add-episode-container').toggleClass('add-episode-container .add-episode-container-show');
    });

});