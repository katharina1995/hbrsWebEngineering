<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://unpkg.com/vue/dist/vue.js"></script>

<style>
.grow { transition: all .2s ease-in-out; }
.grow:hover { transform: scale(2); }

 ul {
  	list-style-type: none;
 }
 li {
 	padding-top: 5px;
 	padding-bottom: 5px;
 }
 #vertical {
  list-style-type: none;
  margin: 0;
  padding: 0;
  width: 130px;
    background-color: #333;
}

#horizontal {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

.lihorizontal {
  float: left;
}

.ahorizontal {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  width: 100px;
}

li a:hover:not(.active) {
  background-color: #555;
  color: white;
}

.active {
    background-color: #4CAF50;
  color: white;
}


.avertical {
  display: block;
  color: white;
  padding: 8px 16px;
  text-decoration: none;
}

.item1 { 
	grid-area: red;
	background-color: white;
}

.item2 { 
	grid-area: green; 
	height: 60vh;
	background-color: white;
}
.item3 { 
	grid-area: blue; 
	height: 60vh;
	background-color: white;
}
.item4 { 
	grid-area: fuchsia; 
	height: 60vh;
	background-color: fuchsia;
}

.grid-container {
  display: grid;
  grid-template-areas:
      'red red red red red'
    'green blue blue blue fuchsia';
  grid-gap: 2%;
  padding: 10px;
}
</style>

</head>

<body>

<script type="module">
 import { LitElement, html } from 'https://unpkg.com/lit-element/lit-element.js?module';

 export class CounterWithLimit extends LitElement {
	static properties = {
		limit: {type: Number},
		value: {type: Number},
		buttonColor: {type: String}
	};
	
	constructor() {
    super();
	this.limit = 10;
	this.value = 0;
	this.buttonColor = "";
  }
	
	render() {
return html`
 <button @click="${this.count}" style="background-color: ${this.buttonColor}">${this.value}</button>
 `;
	}	
	
	count() {
		if(this.value < this.limit) {
			this.value++;
			if(this.value == this.limit) {
			this.buttonColor = "red";
			var that = this;
			setTimeout(function(){ that.buttonColor = ""; }, 1500);
			
			}
		}
	}
	

 }
 
 customElements.define('counter-with-limit', CounterWithLimit);
  </script>
  
  <script type="module">
 import { LitElement, html } from 'https://unpkg.com/lit-element/lit-element.js?module';

 export class MyStoppuhr  extends LitElement {
	static properties = {
		time: {type: String},
		intervalFunction: {type: Object}
	};
	
	constructor() {
    super();
	this.time = "00:00:00";
	this.intervalFunction = "";
  }
	
	render() {
return html`
<p>${this.time}</p>
 <button @click="${this.start}">Start</button>
 <button @click="${this.stop}">Stopp</button>
 <button @click="${this.resume}">Weiter</button>
 `;
	}	
	
	start() {
		clearInterval(this.intervalFunction);
		this.time = "00:00:00";
		var that = this;
		this.intervalFunction = setInterval(function() {that.counterSeconds();}, 1000);
	}
	
	stop() {
		clearInterval(this.intervalFunction);
	}
	
	resume() {
		var that = this;
		this.intervalFunction = setInterval(function() {that.counterSeconds();}, 1000);
	}
	
	counterSeconds() {
	var time = this.time.split(":");
	var seconds = parseInt(time[2]);
	var minutes = parseInt(time[1]);
	var hours = parseInt(time[0]);
	if(parseInt(time[2]) < 59) {
		seconds = parseInt(time[2]) + 1; 
	}
	else {
		seconds = "00";
		if(parseInt(time[1]) < 59) {
			minutes = parseInt(time[1]) + 1;
		} 
		else {
			minutes = "00";
			hours = parseInt(time[0]) + 1;
		}
	}
	seconds = ("0" + seconds).slice(-2);
	minutes = ("0" + minutes).slice(-2);
	hours = ("0" + hours).slice(-2);
	var newTime = hours + ":" + minutes + ":" + seconds;
	this.time = newTime;
}
 }
 
 customElements.define('my-stoppuhr', MyStoppuhr);
</script>
  
  <script type="module">
 import { LitElement, html , css} from 'https://unpkg.com/lit-element/lit-element.js?module';

 export class BarChart  extends LitElement {
	
	constructor() {
    super();
	this.data = '';
		this.p0_x = 0;
	this.p0_y = 500;
	this.p1_x = 100;
	this.p1_y = 400;
	this.p2_x = 200;
	this.p2_y = 500;
	this.loadData();
	
  }
   static get styles() {
    return css`
    .grow { transition: all .2s ease-in-out; }
.grow:hover { transform: scale(2); }
    `;    
    }
	
	render() {
return html`
	<svg width="800" height="500" id="svgElement">
		<line x1="50" y1="450" x2="650" y2="450" style="stroke:rgb(0,0,0);stroke-width:1" />
		<line x1="50" y1="50" x2="50" y2="450" style="stroke:rgb(0,0,0);stroke-width:1" />
		
		<text x="20" y="425">25</text>
		<text x="20" y="400">50</text>
		<text x="20" y="375">75</text>
		<text x="20" y="350">100</text>
		<text x="20" y="325">125</text>
		<text x="20" y="300">150</text>
		<text x="20" y="275">175</text>
		<text x="20" y="250">200</text>
		<text x="20" y="225">225</text>
		<text x="20" y="200">250</text>
		<text x="20" y="175">275</text>
		<text x="20" y="150">300</text>
		<text x="20" y="125">325</text>
		<text x="20" y="100">350</text>
		<text x="20" y="75">375</text>
		
	</svg>
 `;
	}

	loadData() {
		Promise.all([
			fetch('8_2_data.json').then(x => x.json())
		]).then((sampleResp) => {
			this.data = sampleResp;
			var x=100;
			var svgElement = this.shadowRoot.getElementById('svgElement');
			for (var key in this.data[0]) {
				var text = document.createElementNS("http://www.w3.org/2000/svg", "text");
				text.setAttribute("x", x);
				
				text.setAttribute("y", "470");
				text.innerHTML = key;
				svgElement.appendChild(text);
				
				var height = this.data[0][key];
				var rect = document.createElementNS("http://www.w3.org/2000/svg", "rect");
				rect.setAttribute("x", x-25);
				rect.setAttribute("y", 450-height);
				rect.setAttribute("width", "60");
				rect.setAttribute("height", height);
				svgElement.appendChild(rect);
				
				
				var animate = document.createElementNS("http://www.w3.org/2000/svg", "animate");
				animate.setAttribute("attributeName", "height");
				animate.setAttribute("from", "0");
				animate.setAttribute("to", height);
				animate.setAttribute("dur", "5s");
				animate.setAttribute("fill", "freeze");
				rect.appendChild(animate);
				
				var animate1 = document.createElementNS("http://www.w3.org/2000/svg", "animate");
				animate1.setAttribute("attributeName", "y");
				animate1.setAttribute("from", "450");
				animate1.setAttribute("to", 450-height);
				animate1.setAttribute("dur", "5s");
				animate1.setAttribute("fill", "freeze");
				rect.appendChild(animate1);
				
				x = x + 100;
			}
			var line1 = document.createElementNS("http://www.w3.org/2000/svg", "line");
				line1.setAttribute("x1", this.p0_x);	
				line1.setAttribute("y1", this.p0_y);
				line1.setAttribute("x2", this.p1_x);	
				line1.setAttribute("y2", this.p1_y);
				
				svgElement.appendChild(line1);
		});
	}

 }
 
 customElements.define('bar-chart', BarChart);
  </script>
  
  	<!--FadeIn / FadeInOut aus folgender Quelle: https://medium.com/cloud-native-the-gathering/how-to-use-css-to-fade-in-and-fade-out-html-text-and-pictures-f45c11364f08 (zuletzt besucht am: 09.07.2020) -->
  <script type="module">
 import { LitElement, html,  css } from 'https://unpkg.com/lit-element/lit-element.js?module';

 export class BezierAnimation  extends LitElement {
	static properties = {
		time: {type: String},
		intervalFunction: {type: Object}
	};
	
	static get styles() {
    return css`
       @keyframes FadeIn { 
  0% {
    opacity: 0;
  }

  100% {
    opacity: 1;
  }
}

.myClass {
  animation: FadeIn 0.2s linear;
  animation-fill-mode: both;
}

    @keyframes FadeInOut { 
  0% {
    opacity: 0;
  }
  50% {
	opacity: 1;
  }
  100% {
	opacity: 0;
  }
}

.myClassOut {
  animation: FadeInOut 0.2s linear;
  animation-fill-mode: both;
}
    `;
  }
	
	constructor() {
    super();
	this.intervalFunction = "";
	this.data = '';
		this.p0_x = 0;
	this.p0_y = 500;
	this.p1_x = 100;
	this.p1_y = 400;
	this.p2_x = 200;
	this.p2_y = 500;
	
	
  }
	
	render() {
return html`
	<svg width="800" height="500" id="svgElement" class="myClass">
		
	</svg>
 `;
	}

	updated(changedProperties) {

			var x=0.1;
			var y=0.6;
			var svgElement = this.shadowRoot.getElementById('svgElement');
			var line1 = document.createElementNS("http://www.w3.org/2000/svg", "line");
				line1.setAttribute("x1", this.p0_x);	
				line1.setAttribute("y1", this.p0_y);
				line1.setAttribute("x2", this.p1_x);	
				line1.setAttribute("y2", this.p1_y);
				line1.setAttribute("stroke", "black");
				
			var line2 = document.createElementNS("http://www.w3.org/2000/svg", "line");
				line2.setAttribute("x1", this.p1_x);	
				line2.setAttribute("y1", this.p1_y);
				line2.setAttribute("x2", this.p2_x);	
				line2.setAttribute("y2", this.p2_y);
				line2.setAttribute("stroke", "black");
				svgElement.appendChild(line1);
				svgElement.appendChild(line2);
				
				for(var i=0; i<=1; i=i+0.01) {
			var b_x = (1-i)*(1-i)*this.p0_x + 2*i*(1-i)*this.p1_x + i*i*this.p2_x;
			var b_y = (1-i)*(1-i)*this.p0_y + 2*i*(1-i)*this.p1_y + i*i*this.p2_y;
			var p_x = this.p0_x + i * (this.p1_x - this.p0_x);
			var p_y = this.p0_y + i * (this.p1_y - this.p0_y);
			var q_x = this.p1_x + i * (this.p2_x - this.p1_x);
			var q_y = this.p1_y + i * (this.p2_y - this.p1_y);
			var circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
			circle.setAttribute("cx", b_x);
			circle.setAttribute("cy", b_y);
			circle.setAttribute("r", "2");
			circle.setAttribute("class", "myClass");
			circle.setAttribute("style", "animation-delay:" + x+ "s"); 
			x = x+ 0.1;
			svgElement.appendChild(circle);
			var line3 = document.createElementNS("http://www.w3.org/2000/svg", "line");
				line3.setAttribute("x1", p_x);	
				line3.setAttribute("y1", p_y);
				line3.setAttribute("x2", q_x);	
				line3.setAttribute("y2", q_y);
				line3.setAttribute("stroke", "green");
		
							line3.setAttribute("class", "myClassOut");
			line3.setAttribute("style", "animation-delay:" + y +"s");
				svgElement.appendChild(line3);
			
			
			y = y+0.1;
			}
			

	}

 }
 
 customElements.define('bezier-animation', BezierAnimation);
  </script>
  
  <!-- Folgendes Modul ist größtenteils aus der folgenden Quelle: https://www.npmjs.com/package/lit-element-router/v/2.0.0-rc.10 (zuletzt besucht am: 09.07.2020)
   Im Modul verwendetes css aus folgenden Quellen: https://www.w3schools.com/css/css_navbar_vertical.asp (zuletzt besucht am: 09.07.2020)
 und https://www.w3schools.com/css/css_navbar_horizontal.asp (zuletzt besucht am: 09.07.2020) -->
  <script type="module">
 import { LitElement, html, css } from 'https://unpkg.com/lit-element/lit-element.js?module';
 import {routerMixin, outletMixin, linkMixin} from 'https://unpkg.com/lit-element-router@2.0.0-rc.10/lit-element-router.js?module';
 

export class Main extends outletMixin(LitElement) {
  render() {
    return html`
      <slot></slot>
    `;
  }
}

customElements.define('app-main', Main);

export class Link extends linkMixin(LitElement) {
    static get properties() {
        return {
            href: { type: String }
        };
    }
    constructor() {
        super();
        this.href = '';
    }
    render() {
        return html`
            <a href='${this.href}' @click='${this.linkClick}'>
                <slot></slot>
            </a>
        `;
    }
    linkClick(event) {
        event.preventDefault();
        this.navigate(this.href);
    }
}

customElements.define('app-link', Link);
 
 class App extends routerMixin( LitElement ) {
 
 static get styles() {
    return css`
#vertical {
  list-style-type: none;
  margin: 0;
  padding: 0;
  width: 130px;
    background-color: #fff;
}

#horizontal {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #fff;
}

.lihorizontal {
  float: left;
}

.ahorizontal {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  width: 100px;
}

li a:hover:not(.active) {
  background-color: #555;
  color: white;
}

.active {
    background-color: #4CAF50;
  color: white;
}


.avertical {
  display: block;
  color: white;
  padding: 8px 16px;
  text-decoration: none;
}

.item1 { 
	grid-area: red;
	background-color: white;
}

.item2 { 
	grid-area: green; 
	height: 60vh;
	background-color: white;
}
.item3 { 
	grid-area: blue; 
	height: 60vh;
	background-color: white;
}
.item4 { 
	grid-area: fuchsia; 
	height: 60vh;
	background-color: fuchsia;
}

.grid-container {
  display: grid;
  grid-template-areas:
      'red red red red red'
    'green blue blue blue fuchsia';
  grid-gap: 2%;
  padding: 10px;
}
    `;
  }
static get properties() {
 return {
 route: { type: String },
 params: { type: Object },
 query: { type: Object },
 data: { type: Object }
 };
 }
static get routes() {
 return [{
 name: 'home',
 pattern: '',
 data: { title: 'Home' }
 },
 {
 name: 'info',
 pattern: 'info'
 },
 {
 name: 'verticalInfo',
 pattern: 'verticalInfo'
 }];
 }
constructor() {
 super();
 this.route = '';
 this.params = {};
 this.query = {};
 this.data = {};
 this.jsonData = {};
 this.test();
 this.json = '';
 this.last_horizontal = '';
 this.last_vertical = '';
 this.active_horizontal = '';
 this.active_vertical = '';
 this.lastURL = '';
 }
router(route, params, query, data) {
 this.route = route;
 this.params = params;
 this.query = query;
 this.data = data;
 }
render() {
 return html`
<div class="grid-container">
	<div class="item1">
		<h1>WWW-Navigator</h1>


		<ul id="horizontal">
			<li class="lihorizontal"><app-link class="ahorizontal" id="css" href="index.php/info?data=css">CSS</app-link></li>
			<li class="lihorizontal"><app-link class="ahorizontal" id="html" href="index.php/info?data=html">HTML</app-link></li>
			<li class="lihorizontal"><app-link class="ahorizontal" id="javascript" href="index.php/info?data=javascript">JavaScript</app-link></li>
		</ul>
	</div>

	<div class="item2">
		<ul id="vertical">
		</ul>
	</div>
	
	<div class="item3">
		<app-main active-route=${this.route}>
			<p route='info' id="info" @load=${this.showHorizontal(this.query.data)}>Info ${this.query.data}</p>
			<p route='verticalInfo' id="infoVertical" @load=${this.showVertical(this.query.data)} >Info ${this.query.data}</p>
		</app-main>
		<button type="button" id="back" @click="${this.back}">Zurück</button>
	</div>

	<div class="item4">

	</div>
</div>
 `;
 }
 
 test() {
Promise.all([
  fetch('input.json').then(x => x.json())
]).then(([sampleResp]) => {
this.json = sampleResp;
this.active_horizontal = "css";
this.fillVerticalNavbar("css");
this.last_horizontal = "css";
});



}

fillVerticalNavbar(identifier) {

	var ul = this.shadowRoot.getElementById("vertical");
	ul.innerHTML = '';
	var data = this.json[identifier];
	for(var key in data) {
		var ul = this.shadowRoot.getElementById("vertical");
		var li = document.createElement("LI");
		var a = document.createElement("app-link");
		a.classList.add("avertical");
		a.setAttribute("id", key);
		a.setAttribute("name", identifier)
		a.innerHTML = key;
		a.setAttribute("href", "/verticalInfo?data=" + key);
		li.appendChild(a);
		ul.appendChild(li);
	}
	

	this.active_vertical = ul.getElementsByTagName("app-link")[0].id;
	var text = this.json[identifier][this.active_vertical]["text"];
	this.active_horizontal = identifier;
}

showText(id, identifier) {
	this.shadowRoot.getElementById(this.active_vertical).classList.remove("active");
	this.shadowRoot.getElementById(id).classList.add("active");
	var text = this.json[identifier][id]["text"];
	this.shadowRoot.getElementById("text").innerHTML = text;
	this.last_vertical = this.active_vertical;
	this.active_vertical = id;
	this.last_horizontal = this.active_horizontal;
	this.active_horizontal = identifier;
}

back() {
	window.location.href = this.lastURL;
}

showHorizontal(id) {
const url = window.location.href.split("/")[3];
const route = url.split("?")[0];
if(route == "info") {
if(id) {
this.lastURL = window.location.href;
this.fillVerticalNavbar(id);
const vertical_id = this.active_vertical;
this.active_horizontal = id;
const horizontal = this.json[id];
this.shadowRoot.getElementById("info").innerHTML = horizontal[vertical_id].text;
}
}
}

showVertical(id) {
	const url = window.location.href.split("/")[3];
const route = url.split("?")[0];
if(route == "verticalInfo") {
this.lastURL = window.location.href;
	this.active_vertical = id;
	const horizontal = this.json[this.active_horizontal];
	this.shadowRoot.getElementById("infoVertical").innerHTML = horizontal[id].text;
}
}
}
customElements.define('navigator-with-routing', App);
  </script>
  
<div class="row">
  <div class="col-lg-2">
		<ul>
  			<li><button  type="button" class="btn btn-primary" href="#uebung2" data-toggle="collapse">HTML und CSS</button>
  				<ul id="uebung2" class="collapse">
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_2_3.html')">Aufgabe 2.3</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_2_4.html')">Aufgabe 2.4</button></li>
  				</ul>
  			</li>
  			<li><button  type="button" class="btn btn-primary" href="#uebung3" data-toggle="collapse">Responsive Web Design (RWD)</button>
  				<ul id="uebung3" class="collapse">
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_3_1.html')">Aufgabe 3.1</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_3_2.html')">Aufgabe 3.2</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_3_3.html')">Aufgabe 3.3</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_3_4.html')">Aufgabe 3.4</button></li>
  				</ul>
  			</li>
  			<li><button  type="button" class="btn btn-primary" href="#uebung4" data-toggle="collapse">JavaScript</button>
  				<ul id="uebung4" class="collapse">
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_4_1.html')">Aufgabe 4.1</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_4_2.html')">Aufgabe 4.2</button></li>
  				</ul>
  			</li>
  			<li><button  type="button" class="btn btn-primary" href="#uebung5" data-toggle="collapse">Document Object Model (DOM)</button>
  				<ul id="uebung5" class="collapse">
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_5_1.html')">Aufgabe 5.1</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_5_2.html')">Aufgabe 5.2</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showUebung53('uebung_5_3.html')">Aufgabe 5.3</button></li>
  				</ul>
  			</li>
  			<li><button  type="button" class="btn btn-primary" href="#uebung6" data-toggle="collapse">Asynchrones JavaScript</button>
  				<ul id="uebung6" class="collapse">
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_6_1.html')">Aufgabe 6.1</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_6_2.html')">Aufgabe 6.2</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showUebung63()">Aufgabe 6.3</button></li>
  				</ul>
  			</li>
  			<li><button  type="button" class="btn btn-primary" href="#uebung7" data-toggle="collapse">Molulares Web</button>
  				<ul id="uebung7" class="collapse">
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_7_1.html')">Aufgabe 7.1</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_7_2.html')">Aufgabe 7.2</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_7_3.html')" disabled>Aufgabe 7.3</button></li>
  				</ul>
  			</li>
  			<li><button  type="button" class="btn btn-primary" href="#uebung8" data-toggle="collapse">SVG</button>
  				<ul id="uebung8" class="collapse">
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_8_1.html')">Aufgabe 8.1</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_8_2.html')">Aufgabe 8.2</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_8_3.html')">Aufgabe 8.3</button></li>
  				</ul>
  			</li>
  			<li><button  type="button" class="btn btn-primary" href="#uebung9" data-toggle="collapse">WebApps</button>
  				<ul id="uebung9" class="collapse">
  					<li><button  type="button" class="btn btn-warning" onclick="showExerciceContent('uebung_9_1.html')" disabled>Aufgabe 9.1</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_9_2.html')" disabled>Aufgabe 9.2</button></li>
  				</ul>
  			</li>
  			<li><button  type="button" class="btn btn-primary" href="#uebung10" data-toggle="collapse">Vue.js</button>
  				<ul id="uebung10" class="collapse">
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_10_1.html')">Aufgabe 10.1</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_10_2.html')">Aufgabe 10.2</button></li>
  					<li><button  type="button" class="btn btn-warning" onclick="showExerciceContent('uebung_10_3/src/public/index.html')" disabled>Aufgabe 10.3</button></li>
  				</ul>
  			</li>
  			<li><button  type="button" class="btn btn-primary" href="#uebung11" data-toggle="collapse">MEVN</button>
  				<ul id="uebung11" class="collapse">
  					<li><button  type="button" class="btn btn-warning" onclick="showExerciceContent('uebung_11_1.html')" disabled>Aufgabe 11.1</button></li>
  					<li><button  type="button" class="btn btn-warning" onclick="showExerciceContent('uebung_11_2.html')" disabled>Aufgabe 11.2</button></li>
  				</ul>
  			</li>
  			<li><button  type="button" class="btn btn-primary" href="#uebung12" data-toggle="collapse">PHP</button>
  				<ul id="uebung12" class="collapse">
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_12_1.html')">Aufgabe 12.1</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_12_2.html')">Aufgabe 12.2</button></li>
  					<li><button  type="button" class="btn btn-info" onclick="showExerciceContent('uebung_12_3.html')" disabled>Aufgabe 12.3</button></li>
  				</ul>
  			</li>
		</ul>
	</div>
	<div class="col-lg-10" style="min-height: 95vh; width: 70vw; background-color: lightgrey; margin-top: 10px; margin-left: 80px">
		<div id="exerciceContent" style="display: block"></div>
		<div id="exerciceContentLitElement" style="display: none">
			<counter-with-limit limit="14" value="3" style="display: none" id="counter"></counter-with-limit>
			<my-stoppuhr id="stoppuhr" style="display: none" ></my-stoppuhr>
			<bar-chart id="barChart" style="display: none"  style="display: none" ></bar-chart>
			<bezier-animation id="bezierAnimation" style="display: none" ></bezier-animation>
			<navigator-with-routing id="navigatorWithRouting" style="display: none" ></navigator-with-routing>
		</div>
		 
		 <div id="uebung53"  style="display: none" >
		 <div id="text5_3">
		Text, <code>code</code> <p><strong>und mehr Text</strong></p>
	</div>
	<div id="test2">
	</div>
	<div id="ergebnis">
		<table>
			<tr>
				<th>Befehl</th>
				<th>Zeit lesen</th>
				<th>Zeit schreiben</th>
			</tr>
			<tr>
				<td>innerHTML</td>
				<td id="read_0"></td>
				<td id="write_0"></td>
			</tr>
			<tr>
				<td>innerText</td>
				<td id="read_1"></td>
				<td id="write_1"></td>
			</tr>
			<tr>
				<td>textContent</td>
				<td id="read_2"></td>
				<td id="write_2"></td>
			</tr>
						<tr>
				<td>outerHTML</td>
				<td id="read_3"></td>
				<td id="write_3"></td>
			</tr>
		</table>
	</div>
	</div>
		 
		 
		 <div class="grid-container" id="wwwNavigator"  style="display: none" >
	<div class="item1">
		<h1>WWW-Navigator</h1>


		<ul id="horizontal">
			<li class="lihorizontal"><a class="active ahorizontal" id="css" onclick="fillVerticalNavbar(this.id)">CSS</a></li>
			<li class="lihorizontal"><a class="ahorizontal" id="html" onclick="fillVerticalNavbar(this.id)">HTML</a></li>
			<li class="lihorizontal"><a class="ahorizontal" id="javascript" onclick="fillVerticalNavbar(this.id)">JavaScript</a></li>
		</ul>
	</div>

	<div class="item2">
		<ul id="vertical">
		</ul>
	</div>
	
	<div class="item3">
		<p id="text"></p>
		<button type="button" id="back" onclick="back()">Zurück</button>
	</div>

	<div class="item4">
	
	</div>
</div>
		 
		 
<div id="php1" style="display: none">
<h1>Neuer Account</h1>
	<form method="post" action="?signin=1">
 		<fieldset>
 			<legend>Account anlegen:</legend>
 			Username:<br>
 			<input type="text" name="username">
 			<br>
 			Password:<br>
 			<input type="password" name="password">
 			<br><br>
 			<input type="submit" value="Submit">
 		</fieldset>
	</form>
</div>
<?php
	if(isset($_GET['signin'])) {
 		if ( isset($_POST[ 'username' ]) && isset($_POST[ 'password' ]) ){
 			$username = $_POST[ 'username' ];
 			$password = $_POST[ 'password' ];
 			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
 
 			$strJsonFileContents = file_get_contents("results.json");
			$arrayJsonFileContents = json_decode($strJsonFileContents, true);

			if($arrayJsonFileContents == NULL) {
				$arrayJsonFileContents = [];
			}

			$postData = array();
 			$postData[] = array('password'=> $hashedPassword, 'user'=> $username);

			array_push($arrayJsonFileContents, $postData);

			$json_data = json_encode($arrayJsonFileContents);

 			if ( file_put_contents('results.json', $json_data)){
 				echo "<script>alert('Registered successfully!');  window.location.href='index.php'</script>";
 			}
 		}
 	}
 ?>
 
 <div id="php2" style="display: none">
 	<h1>Login</h1>
		<form method="post" action="?login=1">
 			<fieldset>
 				<legend>Logindaten eingeben:</legend>
 				Username:<br>
 				<input type="text" name="username">
 				<br>
 				Password:<br>
 				<input type="password" name="password">
 				<br><br>
 				<input type="submit" value="Submit">
 			</fieldset>
		</form>
</div>

<?PHP
if(isset($_GET['login'])) {
	if ( isset($_POST[ 'username' ]) && isset($_POST[ 'password' ]) ){
 		$username = $_POST[ 'username' ];
 		$passwd = $_POST[ 'password' ];

 		$strJsonFileContents = file_get_contents("results.json");
		$arrayJsonFileContents = json_decode($strJsonFileContents, true);

		foreach ($arrayJsonFileContents as $value) {
    			$user = $value[0]['user'];
    			$password = $value[0]['password'];

			if($username == $user) {
				if(password_verify($passwd, $password)) {
					echo 'Test';
					echo "<script>alert('Login successfully!');  window.location.href='index.php'</script>";
				}
			}
		}
 	}
}
?>
 
 
	</div>
</div>

<p>*Orange unterlegte Aufgaben wurden aufgrund der Komplexität ihrer Umgebung (Node.js, Datenbank,...) nicht (bzw. nur bedingt) auf dieser Seite umgesetzt.</p>
</body>

<script type="text/javascript">

function showExerciceContent(filename) {
    	$('#stoppuhr').hide();
    	$('#counter').hide();
	$('#barChart').hide();
	$('#exerciceContentLitElement').hide();
   	$('#exerciceContent').show(); 
   	$('#bezierAnimation').hide();
   	$('#navigatorWithRouting').hide();
   	$('#uebung53').hide();
   	$('#php1').hide();
   	$('#php2').hide();
   	$('#wwwNavigator').hide();
   
    
     if(filename === 'uebung_7_1.html') {
    	$('#exerciceContent').hide();
    	$('#exerciceContentLitElement').show();
    	$('#counter').show();
    }
    
    if(filename === 'uebung_7_2.html') {
    	$('#exerciceContent').hide();
    	$('#exerciceContentLitElement').show();
    	$('#stoppuhr').show();
    }
    
    if(filename === 'uebung_8_2.html') {
    	$('#exerciceContent').hide();
    	$('#exerciceContentLitElement').show();
    	$('#barChart').show();
    }
    
      if(filename === 'uebung_8_3.html') {
    	$('#exerciceContent').hide();
    	$('#exerciceContentLitElement').show();
    	$('#bezierAnimation').show();
    }
    
    if(filename === 'uebung_9_1.html') {
    	$('#exerciceContent').hide();
    	$('#exerciceContentLitElement').show();
    	$('#navigatorWithRouting').show();
    }
    
    if(filename === 'uebung_12_1.html') {
    	$('#php1').show();
    	return;
    }
    
     if(filename === 'uebung_12_2.html') {
    	$('#php2').show();
    	return;
    }
     $('#exerciceContent').load(filename);
}

function performance() {
	var testCases = ["innerHTML", "innerText", "textContent", "outerHTML"];
	var text  = $("#text5_3")[0];
	for(var i = 0; i < testCases.length; i++) {
			var start = Date.now();
			var x = $("#text5_3")[0][testCases[i]];
			var milliseconds = Date.now() - start;
			$("#read_" + i).html(milliseconds);
	}
	var content = "Text, <code>code</code> <p><strong>und mehr Text</strong></p>";
	for(var j=0; j < testCases.length; j++) {
			var start = Date.now();
			$("#test2").html(content);
			var milliseconds = Date.now() - start;
			$("#write_" + j).html(milliseconds);
	}
	
}

function showUebung53() {
	$('#uebung53').show();
	$('#wwwNavigator').hide();
	$('#exerciceContentLitElement').hide();
   	$('#exerciceContent').hide();
   	$('#stoppuhr').hide();
    	$('#counter').hide();
	$('#barChart').hide();
   	$('#bezierAnimation').hide();
   	$('#navigatorWithRouting').hide();
   	$('#php1').hide();
   	$('#php2').hide();
   	performance(); 
}


var json;
var last_horizontal;
var last_vertical;
var active_horizontal;
var active_vertical;

async function test() {
var response = await fetch('input.json');
json = await response.json();
active_horizontal = "css";
fillVerticalNavbar("css");
last_horizontal = "css";

}

function fillVerticalNavbar(identifier, back) {
	document.getElementById(active_horizontal).classList.remove("active");
	document.getElementById(identifier).classList.add("active");
	var ul = document.getElementById("vertical");
	ul.innerHTML = '';
	var data = json[identifier];
	for(var key in data) {
		var ul = document.getElementById("vertical");
		var li = document.createElement("LI");
		var a = document.createElement("A");
		a.classList.add("avertical");
		a.setAttribute("id", key);
		a.setAttribute("name", identifier)
		a.innerHTML = key;
		a.setAttribute("onclick", "showText(this.id, this.name)");
		li.appendChild(a);
		ul.appendChild(li);
	}
	last_vertical = active_vertical;
	last_horizontal = active_horizontal;
	if(!back) {
		ul.getElementsByTagName("a")[0].classList.add("active");
		active_vertical = ul.getElementsByTagName("a")[0].id;
	var text = json[identifier][active_vertical]["text"];
	document.getElementById("text").innerHTML = text;
	active_horizontal = identifier;
	}
	
}

function showText(id, identifier) {
	document.getElementById(active_vertical).classList.remove("active");
	if(identifier != active_horizontal) {
		fillVerticalNavbar(identifier, true);
	}
	document.getElementById(id).classList.add("active");
	var text = json[identifier][id]["text"];
	document.getElementById("text").innerHTML = text;
	last_vertical = active_vertical;
	active_vertical = id;
	last_horizontal = active_horizontal;
	active_horizontal = identifier;
}

function back() {
	showText(last_vertical, last_horizontal);
}


function showUebung63() {
	$('#wwwNavigator').show();
	$('#uebung53').hide();
	$('#exerciceContentLitElement').hide();
   	$('#exerciceContent').hide();
   	$('#stoppuhr').hide();
    	$('#counter').hide();
	$('#barChart').hide();
   	$('#bezierAnimation').hide();
   	$('#navigatorWithRouting').hide();
   	$('#uebung53').hide();
   	$('#php1').hide();
   	$('#php2').hide();
   	test(); 
}
</script>


 
</html>