import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

//import bootstrap bundle
import * as bootstrap from "bootstrap";
window.bootstrap = bootstrap;

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.scss";

import { Application } from "@hotwired/stimulus";
import Lightbox from "stimulus-lightbox";

const application = Application.start();
application.register("lightbox", Lightbox);

// In your application.js (for example)
import "lightgallery/css/lightgallery.css";
