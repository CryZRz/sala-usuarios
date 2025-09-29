//Tanto escribir js vanilla me estreso asi que mejor use Alpine
import Alpine from 'alpinejs';

import "./dashboard/showLoading.js"
import "./computer/editComputer.js"
import "./computer/createComputer.js"
import "./incidence/createIncidence.js"
import "./session/counterMan.js"
import "./session/createSession.js"
import "./components/selectPeriods.js"
import "./rolManager/create.js"
import "./rolManager/edit.js"
import "./profile/addRole.js"
import "./dashboard/logout.js"
import "./dashboard/index.js"
import "./auth/register.js"
import "./profile/tokens.js"
import "./profile/createToken.js"

window.Alpine = Alpine;

Alpine.start();
