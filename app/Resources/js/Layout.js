import React from 'react';
import Header from './layout/Header';
import Footer from './layout/Footer';

class Layout extends React.Component {
    render () {
        return (
            <div  className="container">
                <div className="row">
                    <div className="col-sm-12">
                        <Header />
                    </div>
                </div>
                <div className="row">
                    <div className="col-sm-12">
                        {this.props.children}
                    </div>
                </div>
                <div className="row">
                    <div className="col-sm-12">
                        <Footer />
                    </div>
                </div>
            </div>
        );
    }
};

export default Layout;
