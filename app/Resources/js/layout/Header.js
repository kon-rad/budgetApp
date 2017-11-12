import React from 'react';
import { Nav, Navbar, NavItem } from 'react-bootstrap';

const Header = () => {
    return (
        <Navbar>
            <Navbar.Header>
                <Navbar.Brand>
                    <a href="/">BudgetApp</a>
                </Navbar.Brand>
                <Navbar.Toggle />
            </Navbar.Header>
            <Navbar.Collapse>
                <Nav>
                    <NavItem href="home">Home</NavItem>
                    <NavItem href="page1">About</NavItem>
                    <NavItem href="page2">Start</NavItem>
                </Nav>
            </Navbar.Collapse>
        </Navbar>
    );
};

export default Header;
