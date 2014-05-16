<?php
/*
 * Created on Apr 17, 2010
 *
 * @Copyright Fellicht.nl
 * @Author Mathieu de Ruiter
 */
?>
<?php echo '<?xml version="1.0" encoding="utf-8" ?>'; ?>
<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">
  <channel>
    <title>Naxasius news feed</title>
    <link>http://www.naxasius.com/</link>
    <description>Latest news of the browser game www.naxasius.com.</description>
    <language>en-us</language>
    <pubDate><?php echo date('r');?></pubDate>
    <docs>http://blogs.law.harvard.edu/tech/rss</docs>
    <generator>CakePHP</generator>
    <webMaster>mathieu@naxasius.com</webMaster>
    <?php foreach ($news as $item): ?>
    <item>
      <title><![CDATA[<?php echo $item['News']['title']; ?>]]></title>
      <link><?php echo $this->Html->url('/news/view/'. $item['News']['id']); ?></link>
      <description><![CDATA[<?php if(!empty($item['News']['image'])) {
			echo $this->Html->image('http://www.naxasius.com/img/website/news/'. $item['News']['image'], array('align' => 'left', 'title' => $item['News']['image_title']));
		}
		?><?php echo $item['News']['summary']; ?>]]></description>
       <pubDate><?php echo date('r', strtotime($item['News']['created'])); ?></pubDate>
      <guid><?php echo $this->Html->url('/news/view/'. $item['News']['id']); ?></guid>

    </item>
    <?php endforeach; ?>
  </channel>
</rss>