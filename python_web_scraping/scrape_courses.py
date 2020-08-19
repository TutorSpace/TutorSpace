from bs4 import BeautifulSoup
import requests
import pandas


def filter_func(tag):
    return tag.name == "a" and tag.has_attr("aria-expanded") and tag.has_attr("title") and tag.has_attr("onclick")


def scrape_courses(page_url):
    page = requests.get(page_url)
    soup = BeautifulSoup(page.text, 'html.parser')
    tag_list = soup.find_all(filter_func)
    res_list = []
    for tag in tag_list:
        tag_text = tag.text.strip()
        split_text = tag_text.split()
        res_list.append([split_text[0] + ' ' + split_text[1], tag_text])
    return res_list


if __name__ == '__main__':
    course_list = []

    # Scrapes all pages
    for i in range(1, 121):
        url = "https://catalogue.usc.edu/content.php?catoid=12&catoid=12&navoid=4245&filter%5Bitem_type%5D=3&filter" \
              "%5Bonly_active%5D=1&filter%5B3%5D=1&filter%5Bcpage%5D=" + str(i) + "#acalog_template_course_filter "
        course_list += scrape_courses(url)

    print(course_list)
    df = pandas.DataFrame(course_list, columns=['code', 'name'])
    df.to_csv(r"courses.csv")
