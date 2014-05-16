<?php
/*
 * Created on Aug 31, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<browsergameshub version="0.1" revisit="14" min-width="1024" min-height="600">
	<name>Naxasius</name>
	<site_url>http://www.naxasius.com/</site_url>
	<descriptions>
		<description lang="en">
		Naxasius is a free browser based mmorpg where you play with thousands of other players in a fantasy world.
		Play with your favorite class (Warrior, Priest, Magier or Assassin) and battle up against monsters, raid bosses, npcs and other players.
		</description>
		<description lang="nl">
		Naxasius is een gratis massive multiplayer online rollen spel waar je met duizende spelers in een fantasie wereld speelt.
		Speel met je favoriete class (Krijger, Healer, Magier of een Rogue) en vecht tegen monsters, eind bazen, npcs en andere spelers.
		</description>
	</descriptions>
	<genre>rpg</genre>
	<setting>ancient world</setting>
	<logo_url><?php echo $this->Html->url('/img/website/layout/naxasius-browser-game.png', true); ?></logo_url>
	<status>development</status>
	<payment>free</payment>
	<timing>realtime</timing>
	<developer>
		<name>Fellicht</name>
		<site_url>http://www.fellicht.nl</site_url>
		<logo_url>http://www.fellicht.nl/img/layout/header-logo-fellicht.png</logo_url>
	</developer>
	<screenshots>
		<?php
		foreach($screenshots as $screenshot) {
		?>
		<screenshot>
			<url><?php echo $this->Html->url('/img/website/screenshots/big/'. $screenshot['Screenshot']['image'], true); ?></url>
			<descriptions>
				<description lang="en"><?php echo $screenshot['Screenshot']['description']; ?></description>
			</descriptions>
		</screenshot>
		<?php
		}
		?>
	</screenshots>
</browsergameshub>