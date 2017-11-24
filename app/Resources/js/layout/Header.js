import React from 'react';

const Header = () => {
    return (
        <nav className="navbar navbar-toggleable-md navbar-light bg-faded">
            <a className="navbar-brand" href="#">BudetApp</a>
            <div className=" navbar-collapse" id="navList">
                <ul className="navbar-nav">
                    <li className="nav-item">
                        <a href="#"> Home</a>
                    </li>
                    <li className="nav-item" href="#">
                        <a href="#"> About</a>
                    </li>
                    <li className="nav-item" href="#">
                        <a href="#">Start</a>
                    </li>
                </ul>
            </div>
        </nav>
    );
};

export default Header;
