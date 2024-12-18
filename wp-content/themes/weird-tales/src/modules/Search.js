import $ from 'jquery';
class Search {
    constructor() {
        this.addSearchHtml();
        this.openButton = $('.js-search-trigger');
        this.closeButton = $('.search-overlay__close');
        this.resultsDiv = $('#search-overlay__results');
        this.searchOverlay = $('.search-overlay');
        this.searchField = $("#search-term");
        this.events();
        this.isOverlayOpen = false;
        this.isSpinnerVisible = false;
        this.typingTimer;
        this.previousValue;

    }
    

    events() {
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));
        $(document).on("keydown", this.keyPressDispatcher.bind(this));
        this.searchField.on("keyup", this.typingLogic.bind(this));

    }

    typingLogic() {
        if (this.searchField.val() != this.previousValue) {
            
            clearTimeout(this.typingTimer);
            if (this.searchField.val()) {
                if (!this.isSpinnerVisible) {
                    this.isSpinnerVisible = true;
                    this.resultsDiv.html('<div class="spinner-loader"></div>');
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 750);

            } else {
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
            }
            
        }
        this.previousValue = this.searchField.val();
       
    }

    getResults() {
        $.getJSON(
            blogData.root_url + '/wp-json/wp/v2/search?search=' + this.searchField.val() + '&subtype=post,page,event,member,album,hall',
            results => {
                this.resultsDiv.html(`
                    <h2 class="search-overlay__section-title">Search Results</h2>
                    ${results.length ? '<ul class="link-list min-list">' : '<p>No results found for this keyword.</p>'}
                    ${results
                        .map(
                            item => `
                                <li>
                                    <a href="${item.url}">${item.title} by ${item.authorName}</a> 
                                    <span>(${item.type})</span>
                                </li>
                            `
                        )
                        .join('')}
                    ${results.length ? '</ul>' : ''}
                `);
                this.isSpinnerVisible = false;
            }
        ).fail(() => {
            this.resultsDiv.html('<p>Something went wrong. Please try again.</p>');
            this.isSpinnerVisible = false;
        });
    }

    keyPressDispatcher (e) {
        if (e.keyCode == 83 && !this.isOverlayOpen) {
            this.openOverlay();
        }

        if (e.keyCode == 27) {
            this.closeOverlay();
        }
    }

    openOverlay() {

        this.searchOverlay.addClass('search-overlay--active');
        $("body").addClass("body-no-scroll");
        this.searchField.val('');
        setTimeout(() => this.searchField.focus());
        this.isOverlayOpen = false;
    };

    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active');
        $("body").removeClass("body-no-scroll");
    };

    addSearchHtml() {
        const htmlData = `<div class="search-overlay">
                            <div class="search-overlay__top">
                               <div class="container">
                                  <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                                  <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
                                  <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>  
                               </div>     
                            </div>
                            <div class="container">
                                <div id="search-overlay__results"></div>
                            </div>    
                          </div>`
        $("body").append(htmlData);
    }
}
export default Search