import $ from 'jquery';
class Search {
    constructor() {
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
                this.typingTimer = setTimeout(this.getResults.bind(this), 2000 );

            } else {
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
            }
            
        }
        this.previousValue = this.searchField.val();
       
    }

    getResults() {
      $.getJSON('http://localhost/wordpress_blog/wp-json/wp/v2/posts?search=' + this.searchField.val(), function(posts) {
        
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
        this.isOverlayOpen = false;
    };

    closeOverlay() {
        this.searchOverlay.removeClass('search-overlay--active');
        $("body").removeClass("body-no-scroll");
    };
}
export default Search