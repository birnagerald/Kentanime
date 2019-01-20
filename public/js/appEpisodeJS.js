var $collectionHolder;

// setup an "add a tag" link
var $addTagButton = $('<button type="button" class="add_tag_link btn btn-secondary">Ajouter un épisode</button>');
var $newLinkLi = $('<li></li>').append($addTagButton);

jQuery(document).ready(function () {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.episodes');
    $collectionHolderNew = $('div.episode');

     // add a delete link to all of the existing tag form li elements
     $collectionHolder.find('tr').each(function(index ) {
         
        addTagFormDeleteLink($(this));
        
        $nbOfInputDeleteButton = (index+1)
    });
    
    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);
    
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    console.log($collectionHolder.data('index'));
    if (typeof $nbOfInputDeleteButton == 'undefined'){
        $collectionHolder.data('index', (($collectionHolder.data('index')-1)/3))
    }else{
        $collectionHolder.data('index', (($collectionHolder.data('index')-($nbOfInputDeleteButton+1))/3))
    }
     

    console.log($collectionHolder.data('index'));

    $addTagButton.on('click', function (e) {
        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi, $collectionHolderNew);
    });
});

function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolderNew.data('prototype');
    

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
    var $newFormLi = $('<table class ="table table-striped"></table>').append(newForm);
    $newLinkLi.before($newFormLi);

    // also add a remove button
    $newFormLi.append('<a href="#" class="remove-tag btn btn-danger mt-4 mb-4">x</a>');
        
    $newLinkLi.before($newFormLi);

    // handle the removal, just for this example
    $('.remove-tag').click(function(e) {
        e.preventDefault();
        
        $(this).parent().remove();
    
        console.log($collectionHolder.data('index'));
        
        return false;
    });

}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<button class="btn btn-danger" type="button">Supprimer cet épisode</button>');
    $tagFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $tagFormLi.remove();
    });
}