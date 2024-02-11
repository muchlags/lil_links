$(document).ready(function () {
    var MyApp = new Vue({
        el: '#webapp',
        delimiters: ['${', '}'],
        data: function () {
            return {
                dir: '>',
                pngCount: 9,
                bgCount: 4,
                toggle: 'flex',
                alignment: 'Center',
                panelLeft: '',
                panelRight: 'Output here',
                toggleVal: 'shorten'
            }
        },
        // define methods under the `methods` object
        methods: {
            toggleSwap: function (event) {
                // `this` inside methods points to the Vue instance
                //   alert('Hello ' + this.name + '!')
                // `event` is the native DOM event

                this.toggleVal = this.toggleVal === 'shorten' ? 'inflate' : 'shorten';
                // this.clearLeftPanel();
                if (this.panelRight != 'Output here') {
                    this.panelLeft = this.panelRight;
                    this.panelRight = 'Output here';
                }
                
                console.log(this.toggleVal);
            },
            url_shorten: function () {
                const endpoint = "{{ path('url_shortener',{url: 'test'}) }}";
            },
            clearLeftPanel: function () {
                // $("#url-input").html("");
                this.panelLeft = '';
                this.panelRight = 'Output here';
                $("#url-input").focus();
            },
            processLink: function () {
                // this.panelRight = this.panelLeft + 'test';
                console.log(this.isValidUrl(this.panelLeft));
                if (this.isValidUrl(this.panelLeft)) {
                    this.makeFetchRequest(this.panelLeft);
                } else {
                    alert("Not a vaild URL!");
                }
            },
            copyURLToClipboard: function(){
                const copyText = this.panelRight;
                navigator.clipboard.writeText(copyText).then(function() {
                    console.log('Text copied to clipboard:', copyText);
                }).catch(function(err) {
                    console.error('Unable to copy text to clipboard', err);
                });
                
            },
            makeFetchRequest: function (url) {
                const endpoint = (this.toggleVal === 'shorten' ? '/s/' : '/i/');
                url = encodeURIComponent(url);
                // console.log(url);
                url = btoa(url);
                // console.log(url);
                fetch(endpoint+url, {
                    method: 'GET',
                    // headers: {
                    //     'Content-Type': 'application/json',
                    // },
                    // You can pass data in the body if needed
                    // body: JSON.stringify({}),
                })
                .then(response => {
                    if (!response.ok) {
                        // throw new Error(`HTTP error! Status: ${response.status}`);
                        console.log("Fetch failure!");
                    }
                    return response.json();
                })
                .then(result => {
                    console.log(result); // Log the result from the Symfony controller
                    this.panelRight = (this.toggleVal === 'shorten' ? window.location.protocol + "//" + window.location.host + "/r/" + result : result);

                })
                .catch(error => {
                    console.error('Error:', error.message);
                    alert("No link found!");
                });
            },
            // Function to make the fetch request
            makeFetchRequest2: async function (url) {
                try {
                    
                    const endpoint = "{{ path('"+(this.toggleVal === 'shorten' ? 'url_shortener' : 'url_inflater')+"',{url: '"+url+"'}) }}";
                    // const endpoint = "{{ path('"+(this.toggleVal === 'shorten' ? 'url_shortener' : 'url_inflater')+"',{url: '"+url+"'}) }}";
                    const response = await fetch(apiUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ url: urlToPass }),
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }

                    const data = await response.json();

                    // Assuming the response contains a 'new_url' property
                    const newUrl = data.new_url;

                    // Do something with the new URL, for example, update it in your Vue.js component data
                    console.log('New URL:', newUrl);
                } catch (error) {
                    console.error('Error:', error.message);
                }
            },
            isValidUrl: function (urlString) {
                try {
                    return Boolean(new URL(urlString));
                }
                catch (e) {
                    return false;
                }
            }

        },
        computed: {
            panelLeftLabel: function () {
                return (this.toggleVal === 'shorten' ? 'shorten' : 'inflate').toUpperCase();
            },
            panelRightLabel: function () {
                return (this.toggleVal === 'shorten' ? 'inflate' : 'shorten').toUpperCase();
            }

        },
        mounted() {  
            console.log("Initz!");
            $("#url-input").focus();
            window.addEventListener("keypress", event => {
                // console.log("KeyCode: " + event.keyCode);
                // if (event.keyCode > 48 && event.keyCode < (58)) {
                //     document.getElementById("p" + (event.keyCode - 48)).click();
                // }
                // if (event.keyCode == 43) { //increase avatar size
                //     // var wid = document.getElementById("dispimg").offsetHeight;
                //     // console.log(wid);
                //     // document.getElementById("dispimg").style.height = (parseInt(wid) + 10) + "px";
                //     // console.log(this.zoomIn);
                //     this.zoomIn();

                // }
                // if (event.keyCode == 45) { //decrease avatar size
                //     // var wid = document.getElementById("dispimg").offsetHeight;
                //     // console.log(wid);
                //     // document.getElementById("dispimg").style.height = (parseInt(wid) - 10) + "px";
                //     this.zoomOut();
                // }
            });
        }
    })
});