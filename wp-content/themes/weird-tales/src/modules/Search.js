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
        // Fetch the HTML template
        const templatePath = `${blogData.root_url}/wp-content/themes/weird-tales/templates/results-template.html`;
        $.get(templatePath, template => {
            $.getJSON(
                `${blogData.root_url}/wp-json/wp/v2/search?search=${encodeURIComponent(this.searchField.val())}&subtype=post,page,event,program,professor,campus`,
                results => {
                    // Generate HTML for each section
                    const generalInfoHTML = results.generalInfo.length
                        ? `<ul class="link-list min-list">
                              ${results.generalInfo
                                  .map(
                                      item => `
                                          <li>
                                              <a href="${item.url}">${item.title} by ${item.authorName}</a> 
                                              <span>(${item.type})</span>
                                          </li>
                                      `
                                  )
                                  .join('')}
                            </ul>`
                        : '<p>No results found for this keyword.</p>';
    
                    const programsHTML = results.programs.length
                        ? `<ul class="link-list min-list">
                              ${results.programs
                                  .map(
                                      item => `
                                          <li>
                                              <a href="${item.url}">${item.title}</a> 
                                          </li>
                                      `
                                  )
                                  .join('')}
                            </ul>`
                        : '<p>No results found for this keyword.</p>';
    
                    const professorsHTML = results.professors.length
                        ? `<ul class="proffessor-card">
                              ${results.professors
                                  .map(
                                      item => `
                                           <li class="professor-card_list-item">
                                                <a class="professor-card" href="${item.url}">
                                                    <img class="professor-card_image" src="${item.image}" alt="">
                                                    <span class="professor-card_name">${item.title}</span>
                                                </a>
                                           </li>
                                      `
                                  )
                                  .join('')}
                            </ul>`
                        : '<p>No results found for this keyword.</p>';
                    
                        const eventsHTML = results.events.length
                        ? `<div class="event-summary">
                              ${results.events
                                  .map(
                                      item => `
                                           <a class="event-summary__date t-center" href="${item.url}">
                                                <span class="event-summary__month">${item.day}</span>
                                                <span class="event-summary__day">${item.month}</span>
                                            </a>
                                            <div class="event-summary__content">
                                                <h5 class="event-summary__title headline headline--tiny"><a href="${item.url}">${item.title}</a></h5>
                                                <p>${item.description}<a href="${item.url}" class="nu gray">Learn more</a></p>
                                            </div>       
                                      `
                                  )
                                  .join('')}
                          </div>`  
                        : '<p>No results found for this keyword.</p>';

                        const campusesHTML = results.campuses.length
                        ? `<ul class="link-list min-list">
                              ${results.campuses
                                  .map(
                                      item => `
                                          <li>
                                              <a href="${item.url}">${item.title}</a> 
                                          </li>
                                      `
                                  )
                                  .join('')}
                            </ul>`
                        : '<p>No results found for this keyword.</p>';
    
                    // Replace placeholders in the template
                    const finalHTML = template
                        .replace('{{generalInfo}}', generalInfoHTML)
                        .replace('{{programs}}', programsHTML)
                        .replace('{{professors}}', professorsHTML)
                        .replace('{{campuses}}', campusesHTML)
                        .replace('{{events}}', eventsHTML);
    
                    // Inject the populated template into the results container
                    this.resultsDiv.html(finalHTML);
                    this.isSpinnerVisible = false;
                }
            ).fail(() => {
                this.resultsDiv.html('<p>Something went wrong. Please try again.</p>');
                this.isSpinnerVisible = false;
            });
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
        return false
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