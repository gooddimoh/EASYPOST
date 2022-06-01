import React from "react";
import { Img } from "Templates/Img";
import { compose } from "ramda";
import { withTagDefaultProps } from "Hoc/Template";
import PropTypes from "prop-types";
import { url } from "Services";
import Timer from "./View/Timer";

const propTypes = {
    pref: PropTypes.string.isRequired,
    t: PropTypes.func.isRequired,
};

function Wait({ pref = "auth", t }) {
    if (!window.localStorage.getItem("banTime")) {
        url.redirect("/login");
    }

    return (
        <div className="main-wrap auth">
            <div className={`${pref}__wrap`}>
                <div className={`${pref}__logo`}>
                    <a href="/" className={`${pref}__logo-link`}>
                        <Img img="logo-pic-big" alt="logo" />
                    </a>
                </div>
                <div className={`${pref}__content`}>
                    <div className={`${pref}__title`}>{t("Login")}</div>
                    <div>
                        <Img img="icon-login-wait" />
                    </div>
                    <div className={`${pref}__desc-wait`}>
                        <span className={`${pref}__desc-wait-bold`}>
                            {t("Possibility to enter temporarily locked")}
                        </span>
                    </div>
                    <div className={`${pref}__desc-wait`}>
                        <div>{t("Try again in")}</div>
                        <div>
                            <Timer />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

Wait.propTypes = propTypes;

export default compose(withTagDefaultProps)(Wait);
