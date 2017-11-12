import React from 'react';
import ReactDom from 'react-dom';
import Layout from './Layout';
import Home from './components/Home';

ReactDom.render((
	<Layout> 
		<Home />
	</Layout>
), document.getElementById('app'));