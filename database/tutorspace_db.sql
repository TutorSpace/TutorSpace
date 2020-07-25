-- SELECT
--   t.*,
--   COUNT(p.id) AS post_count

-- FROM posts p
-- INNER JOIN post_tag pt
--   ON p.id = pt.post_id
-- INNER JOIN tags t
--   ON t.id = pt.tag_id
-- GROUP BY
-- 	t.id
-- ORDER BY
-- 	t.id;

    -- get replies count for all the posts
	SELECT
		p.*,
		count(replies.id)
	FROM
		replies
	INNER JOIN posts p
		ON p.id = replies.post_id
	WHERE
		replies.is_direct_reply = true
	GROUP BY
		p.id;

    -- get replies count for all the tags
	SELECT
		t.*,
		count(replies.id)
	FROM
		replies
	INNER JOIN post_tag pt
		ON replies.post_id = pt.post_id
	INNER JOIN tags t
		ON t.id = pt.tag_id
	WHERE
		replies.is_direct_reply = true
	GROUP BY
		t.id
	ORDER BY t.id;


-- select post count per tag
select
  `tags`.*,
  (
    select
      count(*)
    from
      `posts`
      inner join `post_tag` on `posts`.`id` = `post_tag`.`post_id`
    where
      `tags`.`id` = `post_tag`.`tag_id`
  ) as `posts_count`
from
  `tags`
limit
  5;


-- select replies count per post
select
  `posts`.*,
  (
    select
      count(*)
    from
      `replies`
    where
      `posts`.`id` = `replies`.`post_id`
      and `is_direct_reply` = 1
  ) as `replies_count`,
  `post_tag`.`tag_id` as `pivot_tag_id`,
  `post_tag`.`post_id` as `pivot_post_id`
from
  `posts`
  inner join `post_tag` on `posts`.`id` = `post_tag`.`post_id`
where
  `post_tag`.`tag_id` in (1, 2, 3, 4, 5)





