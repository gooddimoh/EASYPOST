import React, { useState } from 'react';
import { ThemeSwitcherButton } from 'Templates/Button';
import { cookieHandlers } from 'Services/Cookie';

const ThemeSwitcher = () => {
    const [current, setCurrent] = useState(document.documentElement.getAttribute('data-theme') || 'light');

    const onClick = () => {
        setCurrent((prevState) => {
            const nextTheme = prevState === 'light' ? 'dark' : 'light';
            cookieHandlers.remove('colorTheme');
            cookieHandlers.set('colorTheme', nextTheme);
            document.documentElement.classList.add('in-change');
            document.documentElement.setAttribute('data-theme', nextTheme);
            setTimeout(() => {
                document.documentElement.classList.remove('in-change');
            }, 500);

            return nextTheme;
        });
    };

    return (
        <div className="switcher">
            <ThemeSwitcherButton onClick={onClick} checked={current === 'light'} />
        </div>
    );
};

export default ThemeSwitcher;
