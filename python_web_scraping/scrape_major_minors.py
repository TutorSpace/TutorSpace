import pandas
from bs4 import BeautifulSoup, NavigableString, Tag
import requests


def major_filter(tag):
    return tag.name == "strong" and tag.text == "Bachelor's Degree"


def minor_filter(tag):
    return tag.name == "strong" and tag.text == "Minor"


def scrape_major_minor(page_url):
    page = requests.get(page_url)
    soup = BeautifulSoup(page.text, 'html.parser')
    tag_list = soup.find_all(major_filter)
    majors = []
    for child in tag_list[0].parent.next_sibling.next_sibling.contents:
        if isinstance(child, NavigableString):
            continue
        if isinstance(child, Tag):
            major = child.contents[1].string.strip()
            split = major.split(' ')
            if split[-1][0] == '(':
                major = major.rsplit(' ', 1)[0]
            if major[-1] == ',':
                major = major[:-1]
            majors.append(major)

    tag_list = soup.find_all(minor_filter)
    minors = []
    for child in tag_list[0].parent.next_sibling.next_sibling.contents:
        if isinstance(child, NavigableString):
            continue
        if isinstance(child, Tag):
            minor = child.contents[1].string
            split = minor.split(' ')
            if split[-1] == 'Minor':
                minor = minor.rsplit(' ', 1)[0]
            minors.append(minor)

    return majors, minors


if __name__ == '__main__':
    url = "https://catalogue.usc.edu/content.php?catoid=11&navoid=3699"
    major_list, minor_list = scrape_major_minor(url)
    df = pandas.DataFrame(major_list, columns=['major'])
    df.to_csv(r"majors.csv")
    df = pandas.DataFrame(minor_list, columns=['minor'])
    df.to_csv(r"minors.csv")

