require('./bootstrap');
import React from 'react';
import { render } from 'react-dom';
import { Router, Route, browserHistory } from 'react-router';

import Root from './components/Root';

render(<Root />, document.getElementById('root'));