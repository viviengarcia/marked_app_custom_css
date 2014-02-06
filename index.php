<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8" />
	<title>Typography FTW</title>
	<link rel="stylesheet" href="css/stylesheet.css">
</head>
<body>
	<div id="wrapper">
		<h1>Formatage et organisation des CSS</h1>

		<p>Les multiples problématiques relatives au formatage et à l&#8217;organisation des CSS et les réponses possibles.</p>

		<h2>Problématiques</h2>

		<h3>Le modèle BEM</h3>

		<p>BEM est une convention de formatage BEM qui favorise un scopage plus direct des éléments HTML via des classes CSS dont le nommage représente la structure de la mise en page. On favorise une vision plus analytique des classes auxquelles on n&#8217;attribue plus de valeur sémantique (par ailleurs largement assumée par les balises HTML5 et les micro-données).
		C&#8217;est une grande avancée pour des CSS classiques, mais les pré-processeurs ajoutent une couche d&#8217;abstraction qui rendent caduques une partie des méthodes employées.</p>

		<p>L&#8217;approche BEM pose un problème car elle est trop spécifique et localisée dans son nommage. Elle produit des noms de classe à rallonge de type : <code>.bloc--element__modifier</code>. Pour peu que le bloc soit un peu long, le nom de classe devient imbuvable : <code>.main-horizontal-nav--main-nav-item__current</code>.
		Le fait d&#8217;utiliser un bloc comme &#8220;header&#8221; ou &#8220;content&#8221; en début de classe revient à scoper en premier et rend le code peu réutilisable. Quand aux modifiers, ils ne devraient pas faire partie de la classe pour des raisons de lisibilité et avoir leur propre classe.</p>

		<p>Sass permet grâce à <code>@extend</code> d&#8217;avoir des noms de classes plus lisibles et sémantiques dans la feuille de style définitive tout en disposant d&#8217;éléments de nommage réutilisables en interne. L&#8217;idée est de créer un ensemble d&#8217;objets simples dont on va attribuer les propriétés CSS aux classes finales qui aurant un nom moins complexe. Cependant, il ne faut pas remplacer le nommage structurel, mais plutôt indiquer les intéractions avec le HTML. Il est tentant de revenir à des classes <em>pseudo-sémantiques</em> comme <code>&lt;h1 class=&quot;main-title&quot;&gt;</code> mais la lecture de la classe par un regard neuf révèlera moins d&#8217;information que <code>&lt;h1 class=&quot;h2-like article_title current&quot;&gt;</code>.</p>

		<p>Une réponse possible est la fusion de bloc et element en un seul terme qui ferait office de &#8220;scope&#8221;, ajout d&#8217;un type et séparation du modifier qui redevient une classe à part entière. L&#8217;abstraction deviendrait : <code>.type_x--scope_y .modifier_z</code>. Bien qu&#8217;il soit facile de cacher le type avec Sass, je trouve plus efficace de l&#8217;indiquer dans la classe CSS finale pour des raisons de maintenabilité.</p>

		<p><strong># À développer #</strong></p>

		<ul>
		<li>pas d&#8217;indications de décoration dans les classes finales, le graphisme étant défini à l&#8217;aide des placeholder selectors <code>%*ma_classe*</code> et inclus via <code>@extend</code>.</li>
		<li>un des buts de ce travail sur la convention de nommage est d&#8217;éviter de multiplier les classes sur les balises html, pour plusieurs raisons:

		<ol>
		<li>À partir d&#8217;un certain point la lisibilité du code est mauvaise ce qui nuit aussi à la maintenabilité.</li>
		<li>La multiplication des classes sur un même élément entraine la dispersion des moyens d&#8217;action sur les balises. Ça facilite la désorganisation du code.</li>
		<li>L&#8217;idée est de déporter l&#8217;ensemble du travail sur le préprocesseur qui est adapté pour gérer les éléments répétitifs, le css natif permettant traitant les détails.</li>
		</ol></li>
		<li>exemples de formatage de nom de classe : <code>.list-container--vertical__page-footer .animated</code> -&gt; <code>.type</code>+<code>--sous-type</code>+<code>__zoning</code>+<code>modifier</code> :

		<ul>
		<li><code>.list-container</code> : architecture en liste avec un contenu en éléments semblables répétés.</li>
		<li><code>sous-type</code> indiquant l&#8217;orientation.</li>
		<li><code>zoning</code> caractérisant localement l&#8217;ensemble d&#8217;éléments</li>
		<li><code>modifier</code> caractérisant temporairement l&#8217;ensemble d&#8217;éléments</li>
		</ul></li>
		</ul>

		<h2>Éléments : contenants et contenus</h2>

		<p>Dans la mise en page, la plupart des balises html peut être qualifiée d&#8217;élément de type contenant, contenu ou intermédiaire <em>(à la fois contenant et contenu)</em>.
		On peut faire les constats suivants :</p>

		<ul>
		<li>Certaines balises telles que <code>&lt;html&gt;</code>, <code>&lt;head&gt;</code>, <code>&lt;span&gt;</code>, <code>&lt;em&gt;</code>, <code>&lt;strong&gt;</code> ou <code>&lt;br /&gt;</code> ne sont pas qualifiées.</li>
		<li>Le seul élément purement contenant est <code>&lt;body&gt;</code>.</li>
		<li>Les <code>&lt;h*&gt;</code>, <code>&lt;p&gt;</code>, et autres balises dont le <code>display</code>est ou devient <code>inline</code>, sont traités comme des contenus.</li>
		<li>Les <strong>éléments intermédiaires</strong> sont les plus courants, tels que <code>&lt;div&gt;</code>, <code>&lt;section&gt;</code>, <code>&lt;article&gt;</code>, <code>&lt;aside&gt;</code>, <code>&lt;header&gt;</code>, <code>&lt;footer&gt;</code>, <code>&lt;form&gt;</code>, les listes, etc.</li>
		</ul>

		<p>Ces éléments intermédiaires posent notamment un problème au niveau du layout et le l&#8217;alignement vertical.</p>

		<h3>Éléments intermédiaires et rythme vertical</h3>

		<p>Un des principaux problèmes qu&#8217;on peut rencontrer dans la maîtrise du rythme vertical est la fusion des marges. Cette règle n&#8217;intervient que sur les marges verticales de deux éléments superposés et les force à n&#8217;être espacés que par la valeur de la marge la plus élevée. En clair, si un <code>&lt;header&gt;</code>avec une marge de 30px précède un <code>&lt;main&gt;</code> avec une marge de 50px, ils ne seront pas espacés de 80px mais de 50px.
		Dans le but de simplifier les calculs dûs aux différents cas de figure rencontrés dans une mise en page complexe, une technique de Harry Roberts, consiste à supprimer toute fusion en n&#8217;utilisant que des <code>margin-top</code>.</p>

		<p>Cependant, les éléments intermédiaires posent problème dans le cas de l&#8217;attribution générale de valeurs pour les <code>margin-top</code>, car plusieurs éléments intermédiaires imbriqués vont ajouter leurs marges.
		Pour y rémédier, on peut distinguer deux situations :</p>

		<ol>
		<li>Le contenant contient un ensemble d&#8217;éléments disparates, voir un seul élément intermédiaire. Il suffit de styliser le premier élément pour qu&#8217;il n&#8217;ait pas de <code>margin-top</code>.</li>
		<li>Le contenant contient un ensemble d&#8217;élements à comportement de type <em>liste</em> : plusieurs éléments semblables (ex: <code>article</code>) se répètent. Ils doivent être espacés verticalement via un <code>margin-top</code>, que l&#8217;on va supprimer du premier élément de liste à l&#8217;aide de la propriété <code>:first-child</code> (IE8+).</li>
		</ol>
	</div>
</body>
</html>